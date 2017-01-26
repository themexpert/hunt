import Vue from 'vue'
import Hunt from '../config/Hunt'
export default {
    state: {
        filter: 'all',
        product_id: null,
        products: [],
        features: [],
        pagination: [],
        page: 1
    },
    mutations: {
        filter_changed(state, filter) {
            state.filter = filter;
        },
        product_changed(state, product_id) {
            state.product_id = product_id;
        },
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
                    },
                    fail => {
                        Hunt.toast('Error loading products list (updateProducts)', 'error');
                    }
                );
        },
        update_features(state) {
            Vue.http.get(Hunt.API_URL + '/products/'+state.product_id+'/features?page='+state.page)
                .then(
                    success => {
                        state.features = success.body.data;
                        state.pagination = success.body.pagination;
                    },
                    fail => {
                        Hunt.toast('Error loading features list (product_changed)', 'error');
                    }
                );
        }
    },
    actions: {
        update_products(ctx) {
            ctx.commit('update_products');
        },
        product_changed({commit, state}, product_id) {
            if(product_id==state.product) return;
            commit('product_changed', product_id);
            commit('update_features');
        },
        apply_filter({commit, state}, filter) {
            if(state.filter==filter) return;
            commit('filter_changed', filter);
            //update features
        },
        infinite_load_features({commit, state}) {
            //load next pages until total page reached
        }
    }
}