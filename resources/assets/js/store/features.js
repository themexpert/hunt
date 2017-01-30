import Vue from 'vue'
import Hunt from '../config/Hunt'
export default {
    state: {
        statuses: [],
        filter: '',
        query: null,
        product_id: null,
        products: [],
        features: [],
        pagination: [],
        page: 1,
        tags: []
    },
    mutations: {
        /**
         * Loads status list from server
         *
         * @param state
         */
        update_statuses(state) {
            Vue.http.get(Hunt.API_URL+'/statuses').then(
                success => {
                    try {
                        state.statuses = [{
                            label: 'All',
                            slug: ''
                        }];
                        Object.keys(success.body.statuses).forEach(x => {
                            state.statuses.push({
                                label: x,
                                slug: x.toLowerCase()
                            });
                        });
                    } catch(e) {
                        Hunt.toast('Error parsing statuses', 'error');
                    }
                },
                fail => {
                    Hunt.toast('Error loading statuses (update_statuses)', 'error');
                    console.log(fail);
                }
            );
        },
        /**
         * Loads products list from server
         *
         * @param state
         */
        update_products(state) {
            Vue.http.get(Hunt.API_URL + '/products')
                .then(
                    success => {
                        let products = [];
                        success.body.data.forEach(x=>{
                            products.push({
                                id: x.id,
                                name: x.name
                            });
                        });
                        state.products = products;
                        Bus.$emit('products_loaded');
                    },
                    fail => {
                        Hunt.toast('Error loading products list (updateProducts)', 'error');
                    }
                );
        },
        /**
         * Loads features list
         *
         * @param state
         * @param type
         */
        update_features(state, type) {
            if(state.product_id==null) return;
            Vue.http.get(Hunt.API_URL + '/products/'+state.product_id+'/features?page='+state.page
                + (state.filter!='' && type!='search'?'&status='+state.filter:'')
                + (type=='search'?'&searchTerms='+state.query:''))
                .then(
                    success => {
                        state.features = success.body.data;
                        state.pagination = success.body.pagination;
                    },
                    fail => {
                        Hunt.toast('Error loading features list (product_changed)', 'error');
                    }
                );
        },

        update_tags(state) {
            Vue.http.get(Hunt.API_URL + '/tags')
                .then(
                    success => {
                        state.tags = [];
                        success.body.forEach(x=>{
                            state.tags.push({
                                label: x.name,
                                value: x.id
                            });
                        });
                    },
                    fail => {
                        console.log(fail);
                        Hunt.toast('Error loading tags list (update_tags)', 'error');
                    }
                );
        }
    },
    actions: {
        /**
         *Updates product ID and invokes update_features
         *
         * @param commit
         * @param state
         * @param product_id
         */
        product_changed({commit, state}, product_id) {
            if(product_id==state.product) return;
            state.product_id = product_id;
            commit('update_features');
        },
        /**
         * Updates filter and invokes update_features
         *
         * @param commit
         * @param state
         * @param filter
         *
         * filter =>   string ||  { filter: 'string', product_id: int}
         */
        apply_filter({commit, state}, filter) {
            if(typeof filter=='object') {
                filter = filter.filter;
                state.product_id = filter.product_id;
            }
            if(state.filter==filter) return;
            state.filter = filter;
            commit('update_features');
        },
        /**
         * Sets the search query and invokes update_features
         *
         * @param commit
         * @param state
         * @param query
         */
        search_features({commit, state}, query) {
            if(state.query==query) return;
            state.query = query;
            commit('update_features', 'search');
        },
        /**
         * Sets the page number and invokes update_features
         *
         * @param commit
         * @param state
         */
        infinite_load_features({commit, state}) {
            //load next pages until total page reached
        }
    }
}