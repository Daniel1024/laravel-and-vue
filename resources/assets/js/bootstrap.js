
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.


window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
*/

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    var token = document.getElementById('token').getAttribute('content');
    request.headers.set('X-CSRF-TOKEN', token);

    next(function (response) {
        if (response.ok) {
            return response;
        }
        if (! (response.data.message === undefined)) {
            var message = 'Ocurrio un error contacte al administrador del sistema';
            if (response.data.message != '') {
                message = response.data.message;
            }
            this.alert.message = message;
            this.alert.display = true;
            setTimeout(function () {
                this.alert.display = false;
            }.bind(this), 6000);
        }
        return response;
    });
});
