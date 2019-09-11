import Vue from 'vue'
import App from './App.vue'
import router from './router'
import http from './lib/http'
import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/antd.css'
import './lib/animate.css'

// import { Button } from 'ant-design-vue';
// import { Layout } from 'ant-design-vue';
// import { Carousel } from 'ant-design-vue';
// import { List } from 'ant-design-vue';
// import { Card } from 'ant-design-vue';
// import { Upload } from 'ant-design-vue';
// import { message } from 'ant-design-vue';
// import { Icon } from 'ant-design-vue';

Vue.config.productionTip = false

Vue.prototype.$http = http;

// Vue.use(Button);
// Vue.use(Layout);
// Vue.use(Carousel);
// Vue.use(List);
// Vue.use(Card);
// Vue.use(Upload);
// Vue.use(Icon);
// Vue.use(message);
Vue.use(Antd);

new Vue({
    render: h => h(App),
    router: router,
}).$mount('#app')