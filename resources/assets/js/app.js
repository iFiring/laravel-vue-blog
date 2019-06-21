import Vue from 'vue';
import Router from 'vue-router';
import routes from './src/router';
import App from './src/App';
import ElementUI from 'element-ui';
import Fly from 'flyio/dist/npm/fly';
import 'element-ui/lib/theme-chalk/index.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Router);
Vue.use(ElementUI);
window.fly = new Fly;
fly.config.headers['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Fly so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  fly.config.headers['X-CSRF-TOKEN'] = token.content;
  fly.config.headers = {
    'X-CSRF-TOKEN': token.content,
    Accept: 'application/json',
  }
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

//添加响应拦截器，响应拦截器会在then/catch处理之前执行
fly.interceptors.response.use(
  response => response,
  (err) => {
    //发生网络错误后会走到这里
    if(!location.href.includes('/login')) {
      if (err.status === 401) app['_router'].push('/login');
    }
  }
)

// 实例化路由
const router = new Router({
  mode: 'history',
  routes
})

const app = new Vue({
  el: '#app',
  router,
  render: h => h(App)
});