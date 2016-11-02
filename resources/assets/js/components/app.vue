<template>
    <div>
        <div class="alert_container">
            <transition name="bounce">
                <p v-if="alert.display" class="alert alert-danger">
                    {{ alert.message }}
                </p>
            </transition>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Categoria</th>
                <th>Nota</th>
                <th width="50px">&nbsp;</th>
            </tr>
            </thead>
            <transition-group tag="tbody" leave-active-class="bounceOut">
                <tr v-for="note in notes"
                    :key="note.id"
                    is="note-row"
                    :note="note"
                    :categories="categories"
                    @update-note="updateNote"
                    @delete-note="deleteNote"></tr>
            </transition-group>
            <tfoot>
            <tr>
                <td>
                    <select-category :categories="categories" :note="new_note"></select-category>
                </td>
                <td>
                    <input type="text" v-model="new_note.note" class="form-control">
                    <error-list :errors="errors"></error-list>
                </td>
                <td>
                    <a href="#" @click.prevent="createNote()">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>

import utils from './../utils';

var resource;

export default {
    data: function () {
        return {
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
        }
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
}
</script>