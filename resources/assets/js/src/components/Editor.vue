<template>
  <el-form ref="form" v-loading="type === 'edit' && !article.title">
    <el-row :gutter="20">
      <el-col :span="20">
        <el-form-item>
          <el-input placeholder="标题" v-model="article.title"></el-input>
        </el-form-item>
      </el-col>
      <el-col :span="4">
        <el-form-item>
          <el-select placeholder="分类" v-model="article.sort">
            <el-option
                v-for="(item, index) in sorts"
                :key="index"
                :label="item.name"
                :value="item.id">
            </el-option>
          </el-select>
        </el-form-item>
      </el-col>
    </el-row>
    <el-row>
      <el-col>
        <el-form-item>
          <el-input
              type="textarea"
              placeholder="请输入内容"
              v-model="article.desc"
          ></el-input>
        </el-form-item>
      </el-col>
    </el-row>
    <el-row>
      <el-form-item>
        <el-container class="cover-container">
          <div v-if="coverName || article.coverName">
            <img class="cover-image" :src="`/storage/images/${coverName ? coverName : article.coverName}`"  alt="cover image"/>
            <span class="cover-image-actions">
              <span
                  class="cover-image-actions-preview"
                  @click="handlePictureCardPreview"
              >
                <i class="el-icon-zoom-in"></i>
              </span>
              <span
                  class="cover-image-actions-delete"
                  @click="handleRemove"
              >
                <i class="el-icon-delete"></i>
              </span>
            </span>
          </div>
          <image-upload
              v-else
              class="image-upload"
              crop-ratio="16:9"
              crop="local"
              @imageuploaded="handleSuccess"
              :headers="headers"
              :data="data"
              :max-file-size="5242880"
              inputOfFile="file"
              extensions="png,gif,jpeg,jpg"
              :url="uploadAction">
            <i class="el-icon-plus upload-icon-plus"></i>
          </image-upload>
        </el-container>
        <el-dialog :visible.sync="dialogVisible">
          <img width="100%" v-if="coverName || article.coverName" :src="`/storage/images/${coverName ? coverName : article.coverName}`" alt="dialog image">
        </el-dialog>
      </el-form-item>
    </el-row>
    <el-row>
      <el-form-item>
        <div class="editor-container">
          <vue-editor id="editor" v-model="article.cnContent" :editorToolbar="customToolbar"></vue-editor>
        </div>
      </el-form-item>
      <!--<el-row>-->
        <!--<div v-html="CnContent"></div>-->
      <!--</el-row>-->
    </el-row>
    <el-row :gutter="20" type="flex" justify="space-between">
      <el-col>
        <el-button type="default" @click="cancel">取消</el-button>
      </el-col>
      <el-col style="text-align: right;">
        <el-switch
            v-model="article.isPublished"
            active-color="#13ce66"
            active-text="发表"
            inactive-text="草稿"
            style="margin: 0 1em;"
        >
        </el-switch>
        <el-button type="primary" @click="checkCreate">发布</el-button>
      </el-col>
    </el-row>
  </el-form>
</template>

<script>
  import { VueEditor } from "vue2-editor";
  import ImageUpload  from './ImageUpload';
  export default {
    name: "edit",

    components: {
      VueEditor,
      ImageUpload
    },

    props: {
      type: String,
      article: Object,
      sorts: Array
    },

    data () {
      const id = this.$route.params.index || 0;
      return {
        customToolbar: [
          ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
          ['blockquote', 'code-block'],
          [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
          [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript

          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          [{ 'direction': 'rtl' }],                         // text direction
          [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent

          [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

          ['image', 'video'],
          ['clean']
        ],
        id: id,
        coverName: '',
        dialogVisible: false,
        uploadAction: '/api/file/image',
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        data: id ? { id: id } : {}
      }
    },

    created() {},

    methods: {
      cancel() {
        this.$router.back();
      },

      checkCreate() {
        const theArticle = this.article;
        const articleBody = {
          title: theArticle.title,
          sort: theArticle.sort || 1,
          description: theArticle.desc,
          cover: this.coverName || this.article['coverName'] || null,
          cn_content: theArticle.cnContent,
          is_draft: theArticle.isPublished ? 0 : 1
        };
        const val = this.article.isPublished ? '发布' : '保存';
        this.$confirm(`确定要${val}吗？`, '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'info',
          center: true
        }).then(() => {
          const id = this.id;
          this.handleRequest(id, articleBody).then(res => {
            console.log(res);
            this.$message({
            type: 'success',
            message: `${val}成功！`
          });
          }).catch(err => {
            this.$message({
              type: 'info',
              message: `${val}失败！`
            });
          })
        }).catch(err => console.log('取消'))
      },

      handleRequest (id, body) {
        if (id) {
          return fly.put(`/api/articles/${id}`, body);
        } else {
          return fly.post(`/api/article`, body);
        }
      },

      handleSuccess(res) {
        console.log(res);
        this.coverName = res['file_name'];
      },

      handlePictureCardPreview() {
        this.dialogVisible = true;
      },

      handleRemove() {
        this.$confirm('删除该封面？', '警告', {
          confirmButtonText: '删除',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          const fileName = this.coverName || this.article['coverName'];
          const id = this.id;
          fly.delete(`/api/file/image?file_name=${fileName}${id ? '&id=' + id : ''}`).then((res) => {
            const response = res.data;
            if (response.status) {
              this.coverName = this.article.coverName = '';
              this.$message({
                type: 'success',
                message: '已删除！'
              });
            } else {
              this.$message({
                type: 'error',
                message: '删除失败！'
              });
            }
          }).catch(() => {
            this.$message({
              type: 'error',
              message: '删除失败！'
            });
          })
        }).catch(() => {
          // Do nothing
        });
      }
    }
  }
</script>

<style lang="scss" scoped>
  .editor-container {
    line-height: initial;
  }
  .cover-container {
    height: 90px;
    width: 160px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;

    .cover-image {
      height: 100%;
      width: auto;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      text-align: center;
      border-radius: 4px;
    }

    .cover-image-actions {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      cursor: default;
      text-align: center;
      color: #fff;
      opacity: 0;
      font-size: 20px;
      background-color: rgba(0, 0, 0, .5);
      transition: opacity .3s;
      &::after {
        display: inline-block;
        content: "";
        height: 100%;
        vertical-align: middle
      }

      span {
        display: none;
        cursor: pointer;
      }

      span + span {
        margin-left: 15px;
      }

      .cover-image-actions-delete {
        position: static;
        font-size: inherit;
        color: inherit;
      }

      &:hover {
        opacity: 1;
        span {
          display: inline-block;
        }
      }
    }

    .image-upload {
      height: 100%;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 1px dashed #c0ccda;
      border-radius: 4px;

      .upload-icon-plus {
        font-size: 28px;
        color: #8c939d;
      }

      &:hover {
        border-color: #409EFF;
      }
    }
  }
</style>
