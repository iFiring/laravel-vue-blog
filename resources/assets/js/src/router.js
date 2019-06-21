// pages
import index from './pages/index';

import blog from './pages/blog/index';
import blogArticles from './pages/blog/articles';
import show from './pages/blog/show';
import about from './pages/blog/about';

import login from './pages/auth/login';
import admin from './pages/admin/index';
import adminArticles from './pages/admin/articles';
import create from './pages/admin/create';
import edit from './pages/admin/edit';
import sorts from './pages/admin/sorts';

export default [
  {
    path: '', component: index,
  },
  {
    path: '/blog',
    component: blog,
    redirect: '/blog/articles',
    children: [
      {
        path: '/blog/articles', component: blogArticles, props: true
      },
      {
        path: '/blog/articles/show/:id', component: show
      },
      {
        path: '/blog/articles/about', component: about
      }
    ]
  },
  {
    path: '/admin',
    redirect: '/admin/articles',
    component: admin,
    children: [
      {
        path: '/admin/articles', component: adminArticles
      },
      {
        path: '/admin/articles/create', component: create
      },
      {
        path: '/admin/articles/edit/:index', component: edit
      },
      {
        path: '/admin/sorts', component: sorts
      }
    ]
  },
  {
    path: '/login',
    component: login
  },
  {
    path: '*',
    redirect: '/articles'
  }
]
