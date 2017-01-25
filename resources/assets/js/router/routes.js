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
        meta: {requiresAuth: false}
    },
    //Reports route
    {
        path: '/reports',
        component: Components.reports.list,
        meta: {requiresAuth: true}
    },
    //Features route
];