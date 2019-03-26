<template>
  <el-container class="login-container">
    <el-form v-model="form" ref="form" class="login-form">
      <el-form-item label="Email">
        <el-input v-model="form.email" type="email"/>
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="form.password" type="password"/>
      </el-form-item>
      <el-button @click="submit">确定</el-button>
    </el-form>
  </el-container>
</template>

<script>
  export default {
    name: "login",

    data() {
      return {
        form: {
          email: '',
          password: ''
        }
      }
    },

    created() {
      fly.get(`/api/user_info`).then(res => {
        if (res.data.info.name) this.$router.push('/admin/articles');
      }).catch(err => {
        console.log(err);
      })
    },

    methods: {
      submit() {
        fly.post(`/login`, this.form).then(res => {
          this.$router.push('/admin/articles');
        }).catch(err => {
          console.log(err);
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;

  .login-form {
    padding: 16px;
    background-color: white;
    border-radius: 8px;
  }
}
</style>
