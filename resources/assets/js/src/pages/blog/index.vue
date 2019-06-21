<template>
  <el-container direction="vertical" class="index-container">
    <el-header class="index-header">
      <a class="index-title">
        <img src="../../resource/flame.svg" alt="flame"/>
        <span>iFiring</span>
      </a>
      <el-menu :default-active="activeIndex" class="index-header-menu" mode="horizontal" @select="handleSelect">
        <el-menu-item class="index-header-menu-item" index="0">首页</el-menu-item>
        <el-menu-item class="index-header-menu-item" v-for="(sort, index) in sorts" :key="sort.id" :index="sort.id.toLocaleString()">{{ sort.name }}</el-menu-item>
        <el-menu-item style="display: none" index="-1">-1</el-menu-item>
        <el-menu-item style="display: none" index="-2">-2</el-menu-item>
      </el-menu>
      <div class="index-header-about" @click="handleAbout" :style="activeIndex === '-1' ? 'border-bottom: 2px solid #409EFF' : ''">关于</div>
    </el-header>
    <el-main id="main" class="index-main">
      <el-row :gutter="16" type="flex" justify="center" style="min-height: 100%">
        <router-view :index="activeIndex" />
      </el-row>
    </el-main>
    <el-footer class="index-footer" height="32px">Design & Code By iFiring</el-footer>
  </el-container>
</template>

<script>
  export default {
    name: "index",

    data() {
      return {
        activeIndex: '0',
        sorts: []
      }
    },

    created() {
      this.initSorts();
    },

    mounted() {
      switch(this.$route.path) {
        case '/blog/articles':
          this.activeIndex = '0';
          break;
        case '/blog/articles/about':
          this.activeIndex = '-1';
          break;
        default:
          this.activeIndex = '-2';
          break;
      }
    },

    methods: {
      initSorts() {
        fly.get(`/api/sorts`).then(res => {
          const response = res.data;
          this.sorts = response.sorts;
        }).catch(err => {
          console.log(err);
        })
      },
      handleSelect(key, keyPath) {
        this.activeIndex = key;
        if(this.$route.path !== '/blog/articles') {
          this.$router.push('/blog/articles');
        }
      },

      handleAbout() {
        this.activeIndex = '-1';
        if(this.$route.path !== '/blog/articles/about') {
          this.$router.push('/blog/articles/about');
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .index-container {
    background: white;
    .index-header {
      display: flex;
      justify-content: space-between;
      .index-title {
        height: 100%;
        float: left;
        font-size: 26px;
        font-weight: lighter;
        display: inline-flex;
        align-items: center;
        margin: 0 24px 0 12px;
        color: #333;
        text-decoration: none;

        img {
          height: 28px;
          margin-right: 8px;
        }
      }

      @media (max-width: 850px) {
        .index-title {
          font-size: 24px;
          margin: 0 16px 0 6px;
          img {
            height: 22px;
            margin-right: 4px;
          }
        }
      }

      @media (max-width: 700px) {
        .index-title {
          margin: 0 8px 0 4px;
          img {
            height: 18px;
          }
          span {
            display: none;
          }
        }
      }

      .index-header-menu {
        flex: 1 1 auto;
        display: flex;
        overflow-x: scroll;
        overflow-y: hidden;

        .index-header-menu-item {
          font-size: 16px;
          border-bottom: unset;
        }
        @media (max-width: 850px) {
          .index-header-menu-item {
            font-size: 16px;
            padding: 0 5px;
          }
        }

        @media (max-width: 700px) {
          .index-header-menu-item {
            font-size: 14px;
            vertical-align: top;
          }
        }

        .is-active {
          border-bottom: 2px solid #409EFF !important;
        }
      }

      .index-header-about {
        font-size: 16px;
        height: 60px;
        line-height: 60px;
        padding: 0 20px;
        cursor: pointer;
        margin: 0;
        border-bottom: solid 1px #e6e6e6;
        color: #909399;
        transition: border-color .3s,background-color .3s,color .3s;
        box-sizing: border-box;
        white-space: nowrap;
        outline: unset;
      }

      @media (max-width: 850px) {
        .index-header-about {
          font-size: 16px;
          padding: 0 5px;
        }
      }

      @media (max-width: 700px) {
        .index-header-about {
          font-size: 14px;
          vertical-align: top;
        }
      }
    }
    .index-main {
      flex: 1 1 auto;
      overflow-y: auto;

    }

    .index-footer {
      text-align: center;
      line-height: 32px;
      font-size: 14px;
    }
  }

</style>
