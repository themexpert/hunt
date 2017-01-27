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
    {
        path: '/features',
        component: Components.feature.list,
        meta: {requiresAuth: true}
    },
    {
        path: '/features/:filter',
        component: Components.feature.list,
        meta: {requiresAuth: true}
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
    {
        path: '*',
        redirect: '/404'
    }
];