<template>
  <el-container v-loading="loading" direction="vertical">
    <el-row :gutter="20" justify="end">
      <el-col :span="24" style="text-align: right;">
        <el-button type="primary" @click="handleCreateOrUpdate(null, null)" round>新增分类</el-button>
      </el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="24">
        <el-table :data="sorts">
          <el-table-column property="id" label="ID" width="150"></el-table-column>
          <el-table-column property="name" label="类名" min-width="200"></el-table-column>
          <el-table-column property="article_num" label="文章" min-width="150"></el-table-column>
          <el-table-column prop="handle" label="操作" width="150">
            <template slot-scope="scope">
              <el-button type="primary" icon="el-icon-edit" circle @click="handleCreateOrUpdate(scope.row.id || null, scope.row.name || '')"></el-button>
              <el-button type="danger" icon="el-icon-delete" circle @click="handleDelete(scope.row.id || null, scope.row.name || '')"></el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-dialog :visible.sync="dialogVisible">
      <el-form
          :model="dynamicValidateForm"
          ref="dynamicValidateForm">
        <el-form-item
            prop="name"
            required
            label="分类名"
            v-if="dialogVisible"
            :rules="{ required: true, message: '名字不能为空' }">
          <el-input v-model="dynamicValidateForm.name" autocomplete="off"/>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="submitForm">Confirm</el-button>
      </span>
    </el-dialog>
  </el-container>
</template>

<script>
  export default {
    name: "sorts",
    
    data() {
      return {
        sorts: [],
        loading: true,
        dialogVisible: false,
        dynamicValidateForm: {
          name: ''
        },
        currentId: null
      }
    },

    created() {
      this.initData();
    },

    methods: {
      initData() {
        this.loading = true;
        // 获取分类表
        fly.get(`/api/admin/sorts`).then(res => {
          this.sorts = res.data.sorts || [];
        }).catch(err => console.log(err)).finally(() => {
          this.loading = false;
        });
      },

      submitForm() {
        this.$refs['dynamicValidateForm'].validate((valid) => {
          if (valid) {
            const name = this.dynamicValidateForm.name;
            const id = this.currentId;
            const type = id ? 'patch' : 'post';
            const url = id ? `/api/admin/sorts/${id}` : `/api/admin/sorts`;
            fly.request(
              url,
              {
                name: name
              },
              {
                method: type
              }).then(res => {
              console.log(res);
            }).catch(err => console.log(err)).finally(() => {
              this.dialogVisible = false;
              this.initData();
            })
          } else {
            return false;
          }
        });
      },

      handleCreateOrUpdate(id, name) {
        this.dialogVisible = true;
        if(id) {
          this.currentId = id;
          this.dynamicValidateForm.name = name;
        } else {
          this.currentId = null;
          this.dynamicValidateForm.name = '';
        }
      },

      handleDelete(id, name) {
        this.$confirm(`您将删除分类-'${name}'，继续?`, '警告', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          fly.delete(`/api/admin/sorts/${id}`).then(res => {
            this.$message({
              type: 'success',
              message: `${name}已删除！`
            });
          }).catch(err => {
            console.log(err)
          }).finally(() => {
            // 刷新列表
            this.initData();
          });
        }).catch((err) => console.log(err));
      }
    }
  }
</script>

<style scoped>

</style>