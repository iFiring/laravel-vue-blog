<template>
  <div class="w-content">
    <div class="w-title">
      iFiring
    </div>

    <p>
      努力做一个终身学习和持续思考的人
    </p>

    <ul class="w-links">
      <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
        <p class="w-links-p">
          <a href="/blog/" target="_blank"><img class="w-icons" src="icons/notes.svg" alt="notes"/></a>
        </p>
      </li>
      <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
        <p class="w-links-p">
          <a href="https://github.com/iFiring" target="_blank"><img class="w-icons" src="icons/github.svg" alt="github"/></a>
        </p>
      </li>
      <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
        <p class="w-links-p">
          <a href="mailto:wchuan@drips.cn" title="wchuan@drips.cn"><img class="w-icons" src="icons/email.svg" alt="email"/></a>
        </p>
      </li>
      <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
        <p class="w-links-p">
          <a href="https://twitter.com/wcdripscn" target="_blank" title=""><img class="w-icons" src="icons/twitter.svg" alt="twitter"/></a>
        </p>
      </li>
      <li class="w-links-li col-xs-1 col-sm-2 col-md-2 col-lg-1">
        <p class="w-links-p">
          <a href="/blog/articles/about" target="_blank"><img class="w-icons" src="icons/user.svg" alt="user"/></a>
        </p>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: "index"
  }
</script>

<style scoped>
  .w-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
  }

  .w-title {
    font-size: 84px;
    margin-bottom: 30px;
  }

  .w-links {
    padding: unset;
  }

  .w-links-li > a {
    padding: 0 2px;
  }

  .w-icons {
    width: 32px;
  }

  .w-links-li {
    display: inline-block;
  }

  .w-links-p {
    height: 54px;
    width: 54px;
    margin: 6px;
    padding: unset;
    border-radius: 27px;
    display: inline-flex;
    text-align: center;
    background-color: white;
    justify-content: center;
    align-items: center;
  }

  .w-links-p > a {
    display: inline-block;
  }
</style>