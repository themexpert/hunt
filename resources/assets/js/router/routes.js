import Components from '../components'
export default [
    //Auth routes
    {
        path: '/login',
        component: Components.auth.login,
        meta: {requiresAuth: false}
    },
    {
        path: '/register',
        component: Components.auth.register,
        meta: {requiresAuth: false}
    },
    {
        path: '/logout'
    },
    //Dashboard-home route
    {
        path: '/',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    //redirects to latest products features list
    {
        path: '/features',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    {
        path: '/users',
        component: Components.users.index,
        meta: {requiresAuth: true}
    },
    {
        path: '/products',
        component: Components.products.index,
        meta: {requiresAuth: true}
    },
    //Search results for query
    {
        path: '/products/search/features/:query',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    //features list of a product
    {
        path: '/products/:product_id/features',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    //filtered features list of a product
    {
        path: '/products/:product_id/features/filter/:filter',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    //single feature item
    {
        path: '/products/:product_id/features/:feature_id',
        component: Components.feature.single_item,
        meta: {requiresAuth:true}
    },

    //Releases routes
    {
        path: '/features/releases',
        component: Components.releases.index,
        meta: {requiresAuth:true}
    },

    //Reports route
    {
        path: '/reports',
        component: Components.reports.index,
        meta: {requiresAuth: true}
    },
    {
        path: '/reports/filter/:type/:value',
        component: Components.reports.index,
        meta: {requiresAuth:true}
    },
    {
        path: '/settings',
        component: Components.settings.index,
        meta: {requiresAuth:true}
    },
    {
        path: '/settings/token',
        component: Components.passport.settings.token,
        meta: {requiresAuth:true}
    },

    //error routes
    {
        path: '/404',
        component: Components.error.e404,
        meta: {requiresAuth: false}
    },
    //redirect all not found routes to 404
    {
        path: '*',
        redirect: '/404'
    }
];