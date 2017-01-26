let Pace = require('pace-progress');
Pace.start();

import Hunt from './config/Hunt'
import md5 from 'md5'
Object.assign(Hunt, {pace: Pace, md5: md5, API_URL: Hunt.BASE_URL+'/api'});

require('./bootstrap');
require('./passport-bootstrap');

import store from './store'
import router from './router'

const app = new Vue({
    store,
    router,
    data() {
        return {

        }
    },
    mounted() {
        Bus.$on('loggedIn', user => {
            this.$store.dispatch('loggedIn', user);
        });
        Bus.$on('loggedOut', ()=>{
            this.$store.dispatch('loggedOut');
        });
        this.$store.dispatch('update_products');
    },
    methods: {
        checkAuth() {
            Vue.http.get(Hunt.BASE_URL + '/refresh')
                .then(
                    success => {
                        if(success.body.loggedIn) {
                            window.Laravel.csrfToken = success.body._token;
                            store.dispatch('loggedIn');
                        }
                    },
                    fail => {
                        console.log(fail);
                        Hunt.toast('Something went wrong. (checkAuth)', 'warning', 3000);
                    }
                );
        }
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },
        userAvatar() {
            return "http://gravatar.com/avatar/"+Hunt.md5(this.$store.getters.userEmail);
        },
        userName() {
            return this.$store.getters.userName;
        }
    }
}).$mount('#app');
if(window.message!='') Hunt.toast(window.message, 'info');

console.log(Hunt);