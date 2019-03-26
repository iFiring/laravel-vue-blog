<template>
  <el-col class="about-container" :xs="24" :sm="18" :md="14" :lg="12" :xl="10">
    <h1 class="title">关于我</h1>
    <p class="desc">
      Hi！我是川川，一名软件设计师 & Web工程师，乐于开源和分享，硬件发烧友，跑步爱好者，Geeker。 我的英文ID是iFiring。
    </p>
    <h1 class="title">个人作品</h1>
    <p class="desc">
      就是这个网站啦啦啦啦啦～～ <a href="https://github.com/iFiring/laravel-vue-blog" target="_blank" title="基于Laravel，Vue和Element-UI的个人博客系统">传送门</a>
    </p>
    <h1 class="title">工作 & 事业</h1>
    <p class="desc">
      2017年毕业于@<a target="_blank" href="http://www.jxufe.cn">江西财经大学</a>·软件工程专业，
      目前在@上海·<a href="https://www.shouqianba.com" target="_blank">收钱吧</a>工作。
      我最喜欢的公司就是华为，她的狼性企业文化对我有独特的吸引力，近几年打算加入华为。
    </p>
    <h1 class="title">书写</h1>
    <p class="desc">
      自从2016年我就开始在自己的博客上写文章，但由于一些原因停止更新了，从2019年初开始重新上线，包括但不限于书单，笔记，技术，随笔和生活，并且计划今年为个人网站项目逐步迭代三个版本。
    </p>
    <h1 class="title">生活</h1>
    <p class="desc">
      平时喜欢看看书，听听歌，美食和短途旅行，也喜欢运动，跑步和户外活动，还会打打乒乓球和羽毛球。并且还喜欢DIY，擅长搞机（如机箱的清灰加速和软件的安装卸载），平时会做些简单的美食。
    </p>
    <p class="desc">
      我不知道未来会发生什么，但是我对现在做的事始终保持着激情，希望能让这个世界变得更加美好，点点滴滴的行动改变着这个世界。
    </p>
    <h1 class="title">格言</h1>
    <p class="desc">
      永远年轻，始终以奋斗者为本；
      永远热泪盈眶，坚信生命的意义在于磨练灵魂。
    </p>
    <h1 class="title">人生目标</h1>
    <p class="desc">
      成为一个持续学习和独立思考的人。
    </p>
  </el-col>
</template>

<script>
  export default {
    name: "about"
  }
</script>

<style lang="scss" scoped>
  .about-container {
    .title {
      text-align: left;
    }
    .desc {
      font-size: 1.1rem;
      line-height: 1.6rem;
    }
  }
</style>
