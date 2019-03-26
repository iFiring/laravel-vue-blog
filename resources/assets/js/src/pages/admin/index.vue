<template>
  <el-container class="admin-container">
    <el-aside class="admin-aside" width="64px">
      <el-menu
          default-active="2"
          class="el-menu-vertical admin-menu"
          @open="handleOpen"
          @close="handleClose"
          @select="menuSelect"
          :collapse="isCollapse"
          background-color="#545c64"
          text-color="#fff"
          active-text-color="#ffd04b"
      >
        <!--<el-menu-item index="1">-->
        <!--<i class="el-icon-location"></i>-->
        <!--<span slot="title">首页</span>-->
        <!--</el-menu-item>-->
        <el-menu-item index="2">
          <i class="el-icon-document"></i>
          <span slot="title">文章管理</span>
        </el-menu-item>
        <el-menu-item index="3">
          <i class="el-icon-menu"></i>
          <span slot="title">分类管理</span>
        </el-menu-item>
      </el-menu>
    </el-aside>
    <el-container class="admin-main-container">
      <el-header class="admin-header">
        <span class="admin-user-name">王小虎</span>
        <el-dropdown @command="handleCommand">
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
  </el-container>
</template>

<script>
  export default {
    name: "admin",

    data () {
      return {
        isCollapse: true
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
          // case '1':
          //   this.$router.push('/');
          //   break;
          case '2':
            this.$router.push('/admin/articles');
            break;
          case '3':
            this.$router.push('/admin/sorts');
          default:
            break;
        }
      },

      handleCommand(command) {
        switch(command) {
          case 'about':
            this.$router.push('/articles/about');
            break;
          case 'logout':
            fly.get('/logout').then(res => {
              console.log(res);
              this.$router.push('/');
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

<style scoped>
  .admin-container {
    height: 100%;
    background-color: white;
  }

  .admin-aside {
    position: relative;
  }

  .admin-home {
    text-align: center;
    line-height: 60px;
    border-right: solid 1px #e6e6e6;
    font-size: 16px;
    font-weight: 400;
  }

  .admin-menu {
    position: absolute;
    bottom: 0;
    top: 0;
    width: 100%;
  }

  .admin-header {
    text-align: right;
    line-height: 60px;
    box-sizing: content-box;
    border-bottom: solid 1px #e6e6e6;
  }

  .admin-user-name {
    margin: 0 14px;
  }

  .admin-main-container {
    overflow-y: scroll;
  }

  .admin-main {
    background-color: white;
  }
</style>