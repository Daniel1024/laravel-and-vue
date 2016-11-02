require('./bootstrap');

import utils from './utils';

Vue.component('error-list', require('./components/error-list.vue'));

Vue.component('select-category', require('./components/select-category.vue'));

Vue.component('note-row', require('./components/note-row.vue'));

var resource;

const vm = new Vue({
    el: '#app',
    data: {
        new_note: {
            note: '',
            category_id: ''
        },
        notes: [],
        errors: [],
        alert: {
            message: '',
            display: false
        },
        categories: []
    },
    mounted: function () {
        resource = this.$resource('/api/v1/notes{/id}');

        resource.get().then((notes) => {
            this.notes = notes.data;
        });
        this.$http.get('/api/v1/categories').then(function (categories) {
            this.categories = categories.data;
        });
    },
    methods: {
        createNote: function() {

            this.errors = [];

            resource.save({}, this.new_note).then((response) => {
                this.notes.push(response.data.note);
                this.new_note.note = '';
                this.new_note.category_id = '';
            }, (response) => {
                this.errors = response.data.errors;
            });
        },
        updateNote: function (component) {
            resource.update({id: component.note.id}, component.draft).then((response) => {
                utils.assign(component.note, response.data.note);
                component.editing = false;
            }, (response) => {
                component.errors = response.data.errors;
            });
        },
        deleteNote: function (note) {
            resource.delete({id: note.id}).then((response) => {
                var index = this.notes.indexOf(note);
                this.notes.splice(index, 1);
            });
        }
    }
});
