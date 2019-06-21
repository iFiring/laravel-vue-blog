<template>
  <el-container class="admin-container">
    <el-header class="admin-header">
      <el-menu
          class="admin-menu"
          mode="horizontal"
          :default-active="menuIndex"
          @open="handleOpen"
          @close="handleClose"
          @select="menuSelect"
      >
        <a class="admin-title" href="/blog/articles">
          <img src="../../resource/flame.svg" alt="flame"/>
          <span>iFiring</span>
        </a>
        <el-menu-item index="1">
          <i class="el-icon-document"></i>
          <span slot="title">文章</span>
        </el-menu-item>
        <el-menu-item index="2">
          <i class="el-icon-menu"></i>
          <span slot="title">分类</span>
        </el-menu-item>
      </el-menu>
      <el-dropdown @command="handleCommand" class="admin-dorpdown">
        <i class="el-icon-setting" style="margin-right: 14px"></i>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item command="about">关于</el-dropdown-item>
          <el-dropdown-item command="logout">注销</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-header>
    <el-main class="admin-main">
      <router-view />
    </el-main>
  </el-container>
</template>

<script>
  export default {
    name: "admin",

    data () {
      return {
        menuIndex: null,
      }
    },

    created() {
      switch (this.$route.path) {
        case '/admin/articles':
          this.menuIndex = '1';
          break;
        case '/admin/sorts':
          this.menuIndex = '2';
          break;
        default:
          this.menuIndex = null;
      }
    },

    methods: {
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },

      menuSelect(key) {
        switch(key) {
          case '1':
            this.$router.push('/admin/articles');
            break;
          case '2':
            this.$router.push('/admin/sorts');
          default:
            break;
        }
      },

      handleCommand(command) {
        switch(command) {
          case 'about':
            this.$router.push('/blog/articles/about');
            break;
          case 'logout':
            fly.get('/api/logout').then(res => {
              delete fly.config.headers.Authorization;
              this.$router.push('/blog');
            }).catch(err => {
              console.log(err);
            });
            break;
          default:
            break;
        }
      }
    }
  }
</script>

<style scoped lang="scss">
  .admin-container {
    height: 100%;
    background-color: white;
    .admin-header {
      text-align: right;
      line-height: 60px;
      box-sizing: content-box;
      border-bottom: solid 1px #e6e6e6;
      .admin-title {
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
      .admin-menu {
        float: left;
        height: 100%;
        line-height: 100%;
        background: transparent;
        padding: 0;
        margin: 0;
      }
      .admin-dorpdown {
        margin: 0 14px;
        float: right;
      }
    }
    .admin-main {
      background-color: white;
      overflow-y: scroll;
    }
  }

</style>