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
    name: "create",

    components: {
      Editor
    },

    data () {
      return {
        type: 'create',
        article: {
          title: '',
          tag: null,
          sort: null,
          desc: '',
          coverUrl: '',
          created_at: '',
          content_raw: '',
          isPublished: true
        },
        sorts: []
      }
    },

    created () {
      // 获取分类表
      fly.get(`/api/sorts`).then(res => {
        this.sorts = res.data.sorts || [];
      }).catch(err => console.log(err));
    },

    beforeDestroy() {},

    methods: {}
  }
</script>

<style lang="scss" scoped>
.ql-toolbar .ql-snow {
  line-height: 100%;
}
</style>