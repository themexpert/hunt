import Vue from 'vue'
import Hunt from './Hunt'

Vue.mixin({
    methods: {
        /**
         * Overrides get method
         *
         * this.get('url');
         *
         * @param url
         */
        get(url) {
            return this.$http.get(Hunt.API_URL + url);
        },
        /**
         * Overrides post method
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
         * Overrides delete method
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