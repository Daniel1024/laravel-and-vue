require('./bootstrap');

Vue.component('error-list', require('./components/error-list.vue'));

Vue.component('select-category', require('./components/select-category.vue'));

Vue.component('note-row', require('./components/note-row.vue'));

const vm = new Vue({
    el: '#app',
    components: {
        app: require('./components/app.vue')
    }
});
