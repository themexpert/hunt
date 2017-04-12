
window._ = require('lodash');

require('./config/mixin');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('select2');
require("materialize-css");
window.moment = require('moment');
require('moment-timezone');
/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
window.Bus = new Vue();
require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    request.headers.set('Accept', 'application/json');
    request.headers.set('Authorization', 'Bearer ' + Laravel.token); //required for passport authentication

    next();
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });


import vueMultiSelect from 'vue-multiselect'
Vue.component('multiselect', vueMultiSelect);

Vue.component('spinner', require('./components/helpers/spinner.vue'));
Vue.component('select2', require('./components/helpers/select2.vue'));
