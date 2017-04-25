import Vue from 'vue'
import Hunt from './Hunt'

Vue.mixin({
    methods: {
        /**
         * Gravatar URL from email
         *
         * @param email
         * @returns {string}
         */
        gravatar(email) {
            return 'http://gravatar.com/avatar/'+Hunt.md5(email)+'?r=pg&d=mm';
        },
        /**
         * Returns promise of get method
         *
         * this.get('url');
         *
         * @param url
         */
        get(url) {
            return this.$http.get(Hunt.API_URL + url);
        },
        /**
         * Returns promise of post method
         *
         * this.post('url', {foo: bar});
         *
         * @param url
         * @param data
         */
        post(url, data) {
            return this.$http.post(Hunt.API_URL + url, data);
        },
        /**
         * Returns promise of delete method
         *
         * this.delete('url', [success=>{}, error=>{}]);
         *
         * @param url
         */
        delete(url) {
            return this.$http.delete(Hunt.API_URL + url);
        }
    },
    computed: {
        /**
         * Determines if the current user admin
         *
         * @returns {*}
         */
        isAdmin() {
            return this.$store.state.auth.user && this.$store.state.auth.user.is_admin;
        },

        lang() {
            const languages = require('./lang/lang');
            if(Hunt.LANG==='') {
                console.log("Language is not defined");
                return languages.en;
            }
            if(Object.keys(languages).indexOf(Hunt.LANG)<0) {
                console.log("Language file " + Hunt.LANG + " not found");
                return languages.en;
            }
            return languages[Hunt.LANG];
        }
    }
});