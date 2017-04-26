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
                                slug: x.toLowerCase(),
                                subject: success.body.statuses[x].subject,
                                message: success.body.statuses[x].message
                            });
                        });
                    } catch(e) {
                        Hunt.toast('Error parsing statuses', 'error');
                    }
                },
                fail => {
                    if(fail.status===403) {
                        Bus.$emit("goto-login");
                    }
                    Hunt.toast(fail.data.message, 'error');
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
                        if(fail.status===403) {
                            Bus.$emit("goto-login");
                        }
                        Hunt.toast(fail.data.message, 'error');
                        console.log(fail);
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
                        state.busy = false;
                        if(fail.status===403) {
                            Bus.$emit("goto-login");
                        }
                        Hunt.toast(fail.data.message);
                        console.log(fail);
                    }
                );
        },
        /**
         * Update tags on server side change
         *
         * @param state
         */
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
                        if(fail.status===403) {
                            Bus.$emit("goto-login");
                        }
                        Hunt.toast(fail.data.message);
                        console.log(fail);
                    }
                );
        },

        /**
         * Removes product from products list
         *
         * @param state
         * @param pd > product that has been deleted
         */
        product_deleted(state, pd) {
            state.products = state.products.filter(product=>{
                return product.id!==pd.id;
            });
        },

        /**
         * Adds new product to the top of list
         *
         * @param state
         * @param product
         */
        new_product_added(state, product) {
            state.products.unshift(product);
        },

        /**
         * Updates a product
         *
         * @param state
         * @param pd
         */
        product_updated(state, pd) {
            state.products = state.products.map(product=>{
                if(product.id===pd.id) {
                    product.name = pd.name;
                    product.description = pd.description;
                }
                return product;
            });
        },

        /**
         * Update vote
         *
         * @param state
         * @param vote
         */
        new_vote(state, vote){
            const feature = state.features.find(feature=>{
                return feature.id===vote.id;
            });
            if(feature===undefined) return;
            if(feature.vote===null) feature.vote = {up: 0, down: 0};
            if(feature.userVoted===0) {
                if(vote.up)
                    feature.vote.up++;
                else
                    feature.vote.down++;
            }
            else {
                if (vote.up === 1) {
                    feature.vote.up++;
                    feature.vote.down--;
                }
                else {
                    feature.vote.up--;
                    feature.vote.down++;
                }
            }
            feature.userVoted = vote.up?1:-1;
            state.features = state.features.map(f=>{
                if(feature.id===f.id) return feature;
                return f;
            });
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