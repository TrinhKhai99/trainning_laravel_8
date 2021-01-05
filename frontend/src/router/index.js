import Vue from 'vue';
import Router from 'vue-router';
import Main from './../pages/Main';
import Product from './../pages/products/Index';
import EditProduct from './../pages/products/Edit'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Main,
      children: [
        { path: '/', component: Product },
        { path: '/products/:id', component: EditProduct, props: true },
      ]
    }
  ]
}) 