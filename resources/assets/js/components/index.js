export default {
    feature: {
        list: require('./features/list.vue'),
        single_item: require('./features/single-item.vue')
    },
    releases: {
        index: require('./releases/releases.vue')
    },
    products: {
        index: require('./products/products.vue')
    },
    reports: {
        index: require('./reports/reports.vue')
    },
    auth: {
        login: require('./auth/login.vue'),
        register: require('./auth/register.vue')
    },
    error: {
        e404: require('./helpers/error-404.vue')
    },
    passport: {
        settings: {
            token: require('./passport/settings/token.vue')
        }
    }
}