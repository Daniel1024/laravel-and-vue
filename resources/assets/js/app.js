
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
        $.getJSON('/api/v1/notes', function (notes) {
            vm.notes = notes;
        });
        $.getJSON('/api/v1/categories', function (categories) {
            vm.categories = categories;
        });
    },
    methods: {
        createNote: function () {

            this.errors = [];

            $.ajax({
                url: '/api/v1/notes',
                method: 'POST',
                data: vm.new_note,
                dataType: 'json',
                success: function (data) {
                    vm.notes.push(data.note);
                    vm.new_note.note = '';
                    vm.new_note.category_id = '';
                },
                error: function (jqXHR) {
                    vm.errors = jqXHR.responseJSON.errors;
                }
            });


        },
        deleteNote: function (note) {
            //resource.delete({id: note.id}).then(function (response) {
            $.ajax({
                url: '/api/v1/notes/' + note.id,
                method: 'DELETE',
                dataType: 'json',
                success: function () {
                    var index = vm.notes.indexOf(note);
                    vm.notes.splice(index, 1);
                },
                error: function (jqXHR) {
                    vm.error = jqXHR.responseJSON.errors[0];
                    $('#error_message').delay(5000).fadeOut(1000, function () {
                        vm.error = '';
                    })
                }
            });

            //});
        },
        updateNote: function (component) {
            /*resource.update({id: component.note.id}, component.draft).then(function (response) {
                utils.assign(component.note, response.data.note);
                component.editing = false;
            }, function (response) {
                component.errors = response.data.errors;
            });*/
            $.ajax({
                url: '/api/v1/notes/' + component.note.id,
                method: 'PUT',
                data: component.draft,
                dataType: 'json',
                success: function (data) {
                    assign(component.note, data.note);
                    component.editing = false;
                },
                error: function (jqXHR) {
                    component.errors = jqXHR.responseJSON.errors;
                }
            });

        }
    }
});
