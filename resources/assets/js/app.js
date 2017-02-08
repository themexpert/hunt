let Pace = require('pace-progress');
Pace.start();

import Hunt from './config/Hunt'
import md5 from 'md5'
/**
 * Assign pace, md5 and API URL in Hunt object
 */
Object.assign(Hunt, {pace: Pace, md5: md5, API_URL: Hunt.BASE_URL+'/api'});

require('./bootstrap');
require('./passport-bootstrap');

import store from './store'
import router from './router'
import Search from './components/search/search.vue'

const app = new Vue({
    store,
    router,
    components: {
        'search': Search
    },
    data() {
        return {
        }
    },
    mounted() {
        /**
         * Listens for login event
         * Loads status and products list from server
         */
        Bus.$on('loggedIn', () => {
            this.$store.commit('update_statuses');
            this.$store.commit('update_products');
            this.$store.commit('update_tags');
        });
    },
    computed: {
        /**
         * Checks if the user logged in
         *
         * @returns {computed.isLoggedIn|getters.isLoggedIn} bool
         */
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },
        /**
         * Returns gravatar URL for user
         *
         * @returns {string}
         */
        userAvatar() {
            return this.gravatar(this.$store.getters.userEmail);
        },
        /**
         * Returns users nick name
         * @returns {computed.userName|getters.userName} string
         */
        userName() {
            return this.$store.getters.userName;
        }
    }
}).$mount('#app');

/**
 * Shows pn page load messages if have any
 *
 * Example: Email address approved
 */
if(window.message!='') Hunt.toast(window.message, 'info');