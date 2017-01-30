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
        path: '/products/:product_id/features/:filter',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    //single feature item
    {
        path: '/features/:feature_id',
        component: Components.feature.single_item,
        meta: {requiresAuth:true}
    },
    //Reports route
    {
        path: '/reports',
        component: Components.reports.list,
        meta: {requiresAuth: true}
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