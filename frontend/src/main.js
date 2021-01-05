import Vue from 'vue'
import App from './App.vue'

import router from './router';
import store from './store';
import VueLodash from 'vue-lodash'
import lodash from 'lodash'
import '../node_modules/nprogress/nprogress.css'
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import NProgress from 'nprogress';

NProgress.configure({ easing: 'ease', speed: 500 });

Vue.use(VueLodash, { lodash: lodash })

/*eslint-disable */
router.beforeResolve((to, from, next) => {
  if (to.name) {
      NProgress.start()
  }
  next()
})

router.afterEach((to, from) => {
  NProgress.done()
})
/*eslint-enable */

import moment from 'moment';
Vue.prototype.moment = moment;

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router:router,
  store:store,
}).$mount('#app')
