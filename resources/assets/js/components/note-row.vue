<template>
    <tr class="animated">
        <template v-if="! editing">
            <td>{{ category_name }}</td>
            <td>{{ note.note }}</td>
            <td>
                <a href="#" @click.prevent="edit()">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <a href="#" @click.prevent="remove()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </td>
        </template>
        <template v-else>
            <td>
                <select-category :categories="categories" :note="draft"></select-category>
            </td>
            <td>
                <input v-model="draft.note" type="text" class="form-control">
                <error-list :errors="errors"></error-list>
            </td>
            <td>
                <a href="#" @click.prevent="update()">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </a>
                <a href="#" @click.prevent="cancel()">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </template>
    </tr>
</template>

<script>

import utils from './../utils';

export default {
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
            var category = utils.findById(this.categories, this.note.category_id);
            return category != null ? category.name : '';
        }
    },
    methods: {
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
        },
        remove: function () {
            this.$emit('delete-note', this.note);
        }
    }
}
</script>
