<template>
  <el-col :xs="24" :sm="18" :md="14" :lg="12" :xl="10" v-loading="loading" style="min-height: 100%">
    <div class="main-card" v-for="(article, index) in articles" :key="index">
      <div class="card-container">
        <div class="card-image-body" @click="handleShow(article.id)">
          <img :src="article.cover ? `/storage/images/${article.cover}` : '/default_cover.jpg'" class="image">
        </div>
        <div style="padding: 14px;">
          <span>{{ article.title }}</span>
          <div class="bottom clearfix">
            <time class="time">{{ article['created_at'] }}</time>
            <el-button type="text" class="button" @click="handleShow(article.id)">详情</el-button>
          </div>
        </div>
      </div>
    </div>
    <el-pagination
        v-if="total"
        class="pagination"
        background
        layout="prev, pager, next"
        :total="total"
        @current-change="currentChange"
    >
    </el-pagination>
  </el-col>
</template>

<script>
  export default {
    name: "articles",

    props: ['index'],

    data() {
      return {
        loading: true,
        articles: [],
        currentPage: 1,
        pageSize: 10,
        total: 0
      }
    },

    created() {
      this.initData();
    },

    updated() {},

    watch: {
      index: function(newIndex, oldIndex) {
        this.currentPage = 1;
        this.initData();
      }
    },

    methods: {
      initData() {
        this.loading = true;
        const sortId = +this.index;
        fly.get(`/articles?page=${this.currentPage}&page_size=${this.pageSize}${ sortId ? `&sort=${sortId}` : '' }`).then(res => {
          const response = res.data;
          this.articles = response.articles.data;
          this.total = response.articles['total'];
        }).catch(err => {
          console.log(err);
        }).finally(() => {
          this.loading = false;
          document.getElementById('main').scrollTop = 0;
        })
      },
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      },

      handleShow(id) {
        this.$router.push(`/articles/show/${id}`);
      },

      currentChange(page) {
        this.currentPage = page;
        this.initData();
      }
    }
  }
</script>

<style lang="scss" scoped>
  .main-card {
    margin: 16px auto;
    display: inline-block;
    color: #303133;

    .card-container {
      margin-top: 30px;
      padding: 0 16px;
      border-radius: 8px;
      transition: .3s;
      background-color: white;
      box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);
      border: 1px solid #ebeef5;
      display: flex;
      flex-direction: column;

      .card-image-body {
        margin-top: -30px;
        z-index: 3;
        cursor: pointer;
        transition: all 200ms cubic-bezier(0.34, 1.8, 0.7, 1);

        .image {
          width: 100%;
          border-radius: 8px;
          pointer-events: none;
        }
      }

      .card-image-body:hover {
        transform: translate3d(0,-16px,0);
      }

      .bottom {
        margin-top: 13px;
        line-height: 12px;

        .time {
          color: #999;
        }

        .button {
          padding: 0;
          float: right;
        }

        .clearfix:before,
        .clearfix:after {
          display: table;
          content: "";
        }

        .clearfix:after {
          clear: both
        }
      }
    }
  }

  .pagination {
    text-align: center;
  }
</style>