<template>
  <el-row>
    <el-col>
      <Editor :type="type" :article="article" :sorts="sorts"/>
    </el-col>
  </el-row>
</template>

<script>
  import Editor from '../../components/Editor';
  export default {
    name: "edit",

    components: {
      Editor
    },

    data () {
      return {
        type: 'edit',
        article: {
          title: '',
          tag: null,
          sort: null,
          desc: '',
          coverName: '',
          cnContent: '',
          isPublished: true
        },
        sorts: []
      }
    },

    created() {
      const id = this.$route.params.index || 1;
      fly.get(`/api/articles/${id}`).then(res => {
        const responseArticle = res.data.article;
        this.article = {
          title: responseArticle.title,
          // tag: null,
          sort: responseArticle['sorts_id'],
          desc: responseArticle.description,
          coverName: responseArticle.cover || '',
          cnContent: responseArticle['content_html'],
          isPublished: responseArticle.is_draft ? false : true
        };
        this.sorts = res.data.sorts || [];
      }).catch(err => console.log(err));
    },

    beforeDestroy() {},

    methods: {}
  }
</script>

<style lang="scss" scoped>
.editor-container {
  line-height: initial;
}
</style>
