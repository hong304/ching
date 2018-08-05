
//window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
// tether required for bootstrap v4 - note Cap T!
window.Tether = require('tether');
window.bootstrap = require('bootstrap');

// might need to be moved to only some pages
window.OwlCarousel = require('owl.carousel');
window.select2 = require('select2');

window.Cookies = require('js-cookie');
window.autogrow = require('jquery.ns-autogrow');

window.Chart = require('chart.js');
/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
//
// window.Vue = require('vue');
// require('vue-resource');

// window.VueTables = require('vue-tables-2')
// import {ServerTable, ClientTable, Event} from 'vue-tables-2';
// Vue.use(ClientTable);
/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

// Vue.http.interceptors.push((request, next) => {
//     request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
//     next();
// });

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
