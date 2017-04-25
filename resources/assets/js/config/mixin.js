import Vue from 'vue'
import Hunt from './Hunt'

Vue.mixin({
    data() {
        return {
            langData: {
                company: null,
                copyright: null,
                language: 'en'
            }
        }
    },
    mounted() {
        this.langData.company = window.company;
        this.langData.copyright = window.copyright;
        this.langData.language = window.language;
        Bus.$on("settings-updated", settings=>{
            this.langData.company = settings.company;
            this.langData.copyright = settings.copyright;
            this.langData.language = settings.LANG;
        });
    },
    methods: {
        /**
         * Gravatar URL from email
         *
         * @param email
         * @param size
         * @returns {string}
         */
        gravatar(email, size) {
            return 'http://gravatar.com/avatar/'+Hunt.md5(email)+'?r=pg&d=mm'+(size?'&s='+size:'');
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
        },
        getLang() {
            const languages = require('./lang/lang');
            if (this.langData.language === '') {
                console.log("Language is not defined");
                return languages.en;
            }
            if (Object.keys(languages).indexOf(this.langData.language) < 0) {
                console.log("Language file " + this.langData.language + " not found");
                return languages.en;
            }
            return languages[this.langData.language];
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
            const lang = this.getLang();
            if(this.langData.company) lang.company = this.langData.company;
            if(this.langData.copyright) lang.copyright = this.langData.copyright;
            return lang.getLang();
        }
    }
});