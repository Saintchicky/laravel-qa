import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

Vue.use(VueRouter)

// On injecte vue-router dans vue
Vue.use(VueRouter);
// On instancie new VueRouter
const router = new VueRouter({
    mode:'history',//url normale
    routes
});

export default router