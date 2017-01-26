import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
import Hunt from '../config/Hunt'
import store from '../store'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next)=>{
    if(to.path=='/logout') {
        Vue.http.get(Hunt.BASE_URL + '/logout')
            .then(
                success => {
                    window.Laravel.csrfToken = success.body._token;
                    Hunt.toast('You have been logged out.', 'info');
                    store.dispatch('loggedOut');
                    router.push('/');
                },
                fail => {
                    console.log(fail);
                    Hunt.toast('Something went wrong. (logout)', 'error', 3000);
                }
            );
    }
    else if(to.path=='/login') {
        Vue.http.get(Hunt.BASE_URL + '/refresh')
            .then(
                success => {
                    if(success.body.loggedIn) {
                        window.Laravel.csrfToken = success.body._token;
                        store.dispatch('loggedIn');
                        router.push('/');
                    }
                    else {
                        next();
                    }
                },
                fail => {
                    console.log(fail);
                    Hunt.toast('Something went wrong. (login)', 'error', 3000);
                }
            );
    }
    else if(to.meta.requiresAuth) {
        Vue.http.get(Hunt.BASE_URL + '/refresh')
            .then(
                success => {
                    if(success.body.loggedIn) {
                        window.Laravel.csrfToken = success.body._token;
                        next();
                    }
                    else {
                        store.state.auth.redirectTo = to.path;
                        router.push('/login');
                    }
                },
                fail => {
                    console.log(fail);
                    Hunt.toast('Something went wrong. (refresh)', 'error', 3000);
                }
            );
    }
    else {
        next();
    }
});
export default router;