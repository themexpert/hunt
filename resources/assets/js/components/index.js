export default {
    feature: {
        list: require('./features/list.vue'),
        single_item: require('./features/single-item.vue')
    },
    reports: {
        index: require('./reports/reports.vue')
    },
    auth: {
        login: require('./auth/login.vue'),
        register: require('./auth/register.vue')
    },
    error: {
        e404: require('./error-404.vue')
    }
}