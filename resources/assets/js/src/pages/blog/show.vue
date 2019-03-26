<template>
  <el-col class="show-container" :xs="24" :sm="18" :md="14" :lg="12" :xl="10">
    <h1 class="title">{{ article.title }}</h1>
    <!--<p class="cover">{{ article.cover }}</p>-->
    <p class="desc">{{ article.description }}</p>
    <p class="created">{{ article.created_at }}</p>
    <p v-html="article.content_html"></p>
  </el-col>
</template>

<script>
  export default {
    name: "show",

    data() {
      return {
        article: {
          title: '',
          cover: '',
          description: '',
          created_at: '',
          content_html: '',
          sort_id: null
        }
      }
    },

    created() {
      this.initData();
    },

    methods: {
      initData() {
        const { id } = this.$route.params;
        fly.get(`/articles/${id}`).then(res => {
          console.log(res);
          const response = res.data;
          this.article = response.article;
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
.show-container {
  .title {
    text-align: center;
  }
  .desc {}
  .created {
    margin-top: 32px;
    text-align: right;
  }
}
</style>