import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';


// On injecte vue-router dans vue
Vue.use(VueRouter);
// On instancie new VueRouter
const router = new VueRouter({
    mode:'history',//url normale
    routes,
    //Pour activer le lien ds le menu
    linkActiveClass:'active'
});
// Pour Info Auth se trouve en bas de la page Spa.blade
// pour checker si loggé pour les pages beforeEach prend 3 paramètres
router.beforeEach((to,from,next)=>{
    if(to.matched.some(r => r.meta.requiresAuth) && !window.Auth.signedIn ){
        // Si pas loggué on va sur la page log
        window.location = window.Urls.login;
        // on sort
        return
    }
    next();
});

export default router;