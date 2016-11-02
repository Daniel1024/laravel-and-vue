
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
/*
Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
*/

function findById(items, id) {
    for (var i in items) {
        if (items[i].id == id) {
            return items[i];
        }
    }
    return null;
}

function assign(original, newData) {
    for(var key in newData) {
        original[key] = newData[key];
    }
}

Vue.component('select-category', {
    template: '#select_category_tpl',
    props: ['categories', 'note']
});

Vue.component('note-row', {
    template: '#note_row_tpl',
    props: ['note', 'categories'],
    data: function () {
        return {
            editing: false,
            errors: [],
            draft: {}
        };
    },
    computed: {
        category_name: function () {
            var category = findById(this.categories, this.note.category_id);
            return category != null ? category.name : '';
        }
    },
    methods: {
        remove: function () {
            this.$emit('delete-note', this.note);
        },
        edit: function () {
            this.errors = [];
            this.draft = JSON.parse(JSON.stringify(this.note));
            this.editing = true;
        },
        cancel: function () {
            this.editing = false;
        },
        update: function () {
            this.$emit('update-note', this);
        }
    }
});

Vue.component('error-list', {
    template: '#error_list_tpl',
    props: ['errors']
});

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
        error: "",
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
        updateNote: (component) => {
            resource.update({id: component.note.id}, component.draft).then((response) => {
                assign(component.note, response.data.note);
                component.editing = false;
            }, (response) => {
                component.errors = response.data.errors;
            });
        },
        deleteNote: (note) => {
            resource.delete({id: note.id}).then((response) => {
                var indexNote = this.notes.indexOf(note);
                this.notes.splice(indexNote, 1);
            });
        }
    }
});
