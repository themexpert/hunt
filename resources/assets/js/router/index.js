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
    Bus.$emit('route-clicked', to);
    /**
     * Runs only once at first on each page load
     *
     * Prepares the app
     * Checks for authentication
     */
    if(!store.state.loaded) {
        Vue.http.get(Hunt.BASE_URL + '/refreshToken')
            .then(
                success => {
                    if(success.body.loggedIn) {
                        window.Laravel.token=success.body.token;
                        Hunt.updateToken(success.body.token);
                        window.Laravel.csrfToken = success.body._token;
                        store.commit('loggedIn', success.body.user);
                        store.state.loaded = true;
                        Bus.$emit('loaded');
                        gotoNext(to, from, next)
                    }
                },
                fail => {
                    if(fail.status==401) {
                        store.state.loaded = true;
                        Bus.$emit('loaded');
                        Hunt.toast('You need to be registered and logged in to use this service.', 'warning', 3000);
                        if(to.path!='/register') router.push('/login'); else gotoNext(to, from, next);
                    }
                    else
                    {
                        Hunt.toast('Something messed up.', 'error', 3000);
                        console.log(fail);
                    }
                }
            );
    }
    else
    {
        gotoNext(to, from ,next);
    }

    /**
     * Router next() wrapper
     *
     * @param to
     * @param from
     * @param next
     */
    function gotoNext(to, from, next) {

        /**
         * Check if the user logging out, we have no view
         */
        if (to.path == '/logout') {
            Vue.http.get(Hunt.BASE_URL + '/logout')
                .then(
                    success => {
                        window.Laravel.csrfToken = success.body._token;
                        Hunt.deleteToken();
                        Hunt.toast('You have been logged out.', 'info');
                        store.dispatch('loggedOut');
                        router.push('/login');
                    },
                    fail => {
                        console.log(fail);
                        Hunt.toast('Something went wrong. (logout)', 'error', 3000);
                    }
                );
        }
        /**
         * Check if the user already logged in
         */
        else if (to.path == '/login' || to.path == 'register') {
            Vue.http.get(Hunt.BASE_URL + '/refresh')
                .then(
                    success => {
                        window.Laravel.csrfToken = success.body._token;
                        if (success.body.loggedIn) {
                            router.push('/');
                        }
                        else {
                            next();
                        }
                    },
                    fail => {
                        console.log(fail);
                        Hunt.toast('Something went wrong. (login/register)', 'error', 3000);
                    }
                );
        }
        /**
         * Check if the requested route requires authentication
         */
        else if (to.meta.requiresAuth) {
            if (window.Laravel.csrfToken == null || store.state.auth.user == null)
                router.push('/login');
            else
                next();
        }
        else {
            next();
        }
    }
});
export default router;