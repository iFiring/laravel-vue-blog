<template>
  <el-form id="editor" ref="article" v-model="article" v-loading="type === 'edit' && !article.title">
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
        <el-container class="cover-container" v-if="article.coverUrl">
          <img class="cover-image" :src="article.coverUrl"  alt="cover image"/>
          <span class="cover-image-actions">
              <span
                  class="cover-image-actions-preview"
                  @click="handlePictureCardPreview"
              >
                <i class="el-icon-zoom-in"></i>
              </span>
              <span
                  class="cover-image-actions-delete"
                  @click="handleCoverInput"
              >
                <i class="el-icon-edit"></i>
              </span>
            </span>
        </el-container>
        <div v-else class="cover-container image-upload" @click="handleCoverInput">
          <i class="el-icon-plus upload-icon-plus"></i>
        </div>
        <el-dialog custom-class="cover-preview" :visible.sync="previewDialog">
          <img width="100%" v-if="article.coverUrl" :src="article.coverUrl" alt="dialog image">
        </el-dialog>
        <el-dialog :visible.sync="coverInputDialog" :close="cancelCoverInput">
          <el-form-item
              label="地址"
          >
            <el-input v-model="coverUrl" autocomplete="off"/>
          </el-form-item>
          <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="addCoverUrl">Confirm</el-button>
          </span>
        </el-dialog>
      </el-form-item>
    </el-row>
    <el-row>
      <el-form-item>
        <el-input
            type="textarea"
            :autosize="{ minRows: 16}"
            placeholder="请输入Markdown"
            :value="article.content_raw"
            @input="updateContent">
        </el-input>
      </el-form-item>
      <el-col class="viewer" :xs="24" :sm="18" :md="14" :lg="12" :xl="10">
        <h1 class="title">{{ article.title }}</h1>
        <!--<p class="cover">{{ article.cover }}</p>-->
        <p class="desc">{{ article.desc }}</p>
        <p class="created">{{ article.created_at }}</p>
        <p class="content" v-html="compiledMarkdown"></p>
      </el-col>
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
  import marked from 'marked';
  export default {
    name: "edit",

    components: {},

    props: {
      type: String,
      article: Object,
      sorts: Array
    },

    data () {
      const id = this.$route.params.index || 0;
      return {
        id: id,
        coverUrl: '',
        previewDialog: false,
        coverInputDialog: false,
        data: id ? { id: id } : {}
      }
    },

    created() {},

    computed: {
      compiledMarkdown: function () {
        return marked(this.article['content_raw'], { sanitize: true })
      }
    },

    methods: {
      cancel() {
        this.$router.back();
      },

      updateContent: function (e) {
        this.article['content_raw'] = e;
      },

      handleCoverInput() {
        this.coverUrl = this.article.coverUrl;
        this.coverInputDialog = true;
      },

      cancelCoverInput() {
        this.coverUrl = '';
      },

      onChangeCover(value) {
        this.coverUrl = value;
      },

      addCoverUrl() {
        this.coverInputDialog = false;
        this.article.coverUrl = this.coverUrl;
      },

      checkCreate() {
        const theArticle = this.article;
        const articleBody = {
          title: theArticle.title,
          sort: theArticle.sort || 1,
          description: theArticle.desc,
          cover: this.coverUrl || this.article['coverUrl'] || null,
          content_raw: theArticle.content_raw,
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
          return fly.put(`/api/admin/articles/${id}`, body);
        } else {
          return fly.post(`/api/admin/article`, body);
        }
      },

      handlePictureCardPreview() {
        this.previewDialog = true;
      },
    }
  }
</script>

<style lang="scss">
  #editor {
    .cover-container {
      height: 90px;
      width: 160px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;

      .cover-image {
        height: 100%;
        width: 100%;
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
    .cover-preview {
      width: auto;
      max-width: 86%;
    }
    .viewer {
      float: unset;
      margin: 0 auto;
      display: block;
      box-sizing: border-box;
      padding: 0 20px;

      .title {
        text-align: center;
      }
      .desc {
      }
      .created {
        margin-top: 32px;
        text-align: right;
      }
      .content {
        /* 目前将scoped删除，v-model的样式才有效，详见：https://github.com/JeffreyWay/laravel-mix/issues/1850 */
        img{
          max-width: 100%;
          display: inline-block;
          padding: 16px 8px;
        }
      }
    }
  }
</style>
