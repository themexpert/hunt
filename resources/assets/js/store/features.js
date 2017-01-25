export default {
    state: {
        filter: 'all',
        product: null,
        products: ['Product 1', 'Product 2', 'Product 3'],
        features: []
    },
    mutations: {
        filter_changed(state, filter) {
            state.filter = filter;
        },
        product_changed(state, product) {
            state.product = product;
        },
        update_products(state, products) {
            state.products = products;
        },
        update_features(state, features) {
            state.features = features;
        }
    },
    actions: {
        product_changed(ctx, product) {
            //load features and commit
            ctx.commit('product_changed', product);
        },
        apply_filter(ctx, filter) {
            //load features applying filter and commit
            ctx.commit('filter_changed', filter);
        }
    }
}