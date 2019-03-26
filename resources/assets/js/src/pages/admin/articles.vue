<template>
  <el-container class="articles-container" v-loading="loading" direction="vertical">
    <el-row class="row">
      <el-button type="success" icon="el-icon-edit" @click="handleCreate()" round>
        新文章
      </el-button>
    </el-row>
    <el-row class="row" >
      <el-table
          :data="tableData"
      >
        <el-table-column
            prop="id"
            label="序号"
            width="60">
        </el-table-column>
        <el-table-column
            prop="cover"
            label="封面"
            width="80">
          <template slot-scope="scope">
            <el-popover
                placement="right"
                width="640"
                trigger="hover">
              <img class="table-column-img-hover" :src="scope.row.cover ? `/storage/images/${scope.row.cover}` : '/default_cover.jpg'" alt="article cover" />
              <img class="table-column-img" slot="reference" :src="scope.row.cover ? `/storage/images/${scope.row.cover}` : '/default_cover.jpg'"/>
            </el-popover>
          </template>
        </el-table-column>
        <el-table-column
            prop="title"
            label="标题"
            min-width="160">
        </el-table-column>
        <el-table-column
            prop="desc"
            label="描述"
            min-width="240">
        </el-table-column>
        <el-table-column
            prop="datetime"
            label="创建时间"
            width="180">
        </el-table-column>
        <el-table-column
            prop="status"
            label="状态"
            width="100">
          <template slot-scope="scope">
            <el-switch
                v-model="scope.row.status"
                active-color="#13ce66"
                @change="handleSwitch(scope.row.id || null)"
            >
            </el-switch>
          </template>
        </el-table-column>
        <el-table-column
            prop="handle"
            width="140"
            label="地址">
          <el-button-group slot-scope="scope">
            <el-button type="primary" circle icon="el-icon-view" @click="handlePreview(scope.row.id || null)"></el-button>
            <el-button type="primary" circle icon="el-icon-edit" @click="handleEdit(scope.row.id || null)"></el-button>
            <el-button type="primary" circle icon="el-icon-delete" @click="handleDelete(scope.row.id || null)"></el-button>
          </el-button-group>
        </el-table-column>
      </el-table>
    </el-row>
    <el-pagination
        class="pagination"
        layout="prev, pager, next"
        :total="total"
        @current-change="currentChange"
    >
    </el-pagination>
  </el-container>
</template>

<script>
  export default {
    name: "articles",

    data() {
      return {
        sortsData: [],
        loading: true,
        tableData: [],
        currentPage: 1,
        pageSize: 10,
        total: 0
      }
    },

    created() {
      this.initData();
    },

    methods: {
      handleSwitch(id) {
        fly.patch(`/api/articles/${id}`).then(res => {
          console.log('切换成功!');
        }).catch(err => {
          // 更新失败则刷新列表
          this.initData();
        });
      },

      handlePreview(id) {
        window.open(`/blog/#/articles/${id}`);
      },

      handleEdit(id) {
        this.$router.push(`/admin/articles/edit/${id}`);
      },

      handleDelete(id) {
        this.$confirm(`您将删除文章'${id}'，继续?`, '警告', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          fly.delete(`/api/articles/${id}`).then(res => {
            this.$message({
              type: 'success',
              message: `${id}已删除`
            });
          }).catch(err => {
            console.log(err)
          }).finally(() => {
            // 刷新列表
            this.initData();
          });
        }).catch((err) => console.log(err));
      },

      initData() {
        this.loading = true;
        fly.get(`/api/articles?page=${this.currentPage}&page_size=${this.pageSize}`).then(res => {
          this.tableData = res.data.data.map(item => {
            return {
              id: item.id,
              cover: item.cover || '',
              title: item.title,
              desc: item.description,
              datetime: item.created_at,
              status: item.is_draft ? false : true
            }
          });
          this.total = res.data['total'];
        }).catch(err => {
          console.log(err)
        }).finally(() => {
          this.loading = false;
        });
      },

      handleCreate() {
        this.$router.push('/admin/articles/create');
      },

      // 更新发布状态（草稿）
      updateStatus() {
        fly.patch()
      },

      currentChange(page) {
        this.currentPage = page;
        this.initData();
      }
    }
  }
</script>

<style lang="scss" scoped>
.articles-container {
  background-color: white;
  flex-direction: column;
  padding: 14px;

  .row {
    margin: 14px 0;
    justify-content: flex-end;

    .table-column-img{
      width: 100px;
    }
  }

  .pagination {
    text-align: center;
  }
}

.table-column-img-hover {
  width: 640px;
  height: auto;
}
</style>
