import Vue from 'vue'
import Hunt from '../config/Hunt'
export default {
    state: {
        statuses: [],
        filter: '',
        product_id: null,
        products: [],
        features: [],
        pagination: [],
        page: 1,
        busy: false,
        tags: []
    },
    mutations: {
        new_vote(state, vote) {
            for(let i=0;i<state.features.length;i++) {
                if(state.features[i].id!=vote.id) continue;
                state.features[i].vote.voted = vote.type=='up'?1:-1;
                if(vote.type=='up') {
                    state.features[i].vote.up++;
                } else {
                    state.features[i].vote.down++;
                }
                break;
            }
        },
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
                        state.products = success.body.data;
                        if(state.products.length==0) {
                            //Nothing to load anymore, so all loaded
                            Bus.$emit('feature-list-loaded', null);
                        }
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
         * @param append
         */
        update_features(state, append=false) {
            if(state.product_id==null || state.busy) return;
            if(append) {
                if(state.pagination!=null && state.pagination.total_page>state.page) {
                    state.page++;
                }
                else {
                    Bus.$emit('feature-list-loaded');
                    Hunt.toast(`You've reached the end.`);
                    return;
                }
            } else { state.page = 1; }
            state.busy = true;
            let type = null;
            Vue.http.get(Hunt.API_URL + '/products/'+state.product_id+'/features?page='+state.page
                + (state.filter!='' && type!='search'?'&status='+state.filter:''))
                .then(
                    success => {
                        if(append)
                            state.features = state.features.concat(success.body.data);
                        else
                            state.features = success.body.data;
                        state.pagination = success.body.pagination;
                        state.busy = false;
                        Bus.$emit('feature-list-loaded');
                    },
                    fail => {
                        Hunt.toast('Error loading features list (product_changed)', 'error');
                        state.busy = false;
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
        }
    }
}