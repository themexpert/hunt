import Vue from 'vue'
import Hunt from './Hunt'

Vue.mixin({
    methods: {
        getDateDiff(d1, d2) {
            return Math.round((d1-d2) / (1000 * 60 * 60 * 24));
        },

        getDateDiffFromToday(date) {
            let diff = this.getDateDiff(new Date(), new Date(date));
            if(!diff) return " today";
            if(diff<30) {
                return diff + ' day(s) ago';
            }
            return Math.floor((diff/30)) + ' month(s) ago';
        },
        /**
         * Gravatar URL from email
         *
         * @param email
         * @returns {string}
         */
        gravatar(email) {
            return 'http://gravatar.com/avatar/'+Hunt.md5(email)+'?s=25&r=pg&d=mm';
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
    }
});