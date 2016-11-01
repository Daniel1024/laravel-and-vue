@extends('layout')

@section('content')
    <div class="row" id="app">
        <div class="col-sm-8 col-sm-offset-2">

            <h1>Curso de VueJS</h1>
            <hr>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Nota</th>
                    <th width="50px">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="note in notes"
                    :key="note.id"
                    is="note-row"
                    :note="note"
                    :categories="categories"
                    @update-note="updateNote"
                    @delete-note="deleteNote"></tr>
                </tbody>
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
            <hr>
            <pre>@{{ $data }}</pre>
        </div>
    </div>
@endsection

@section('scripts')
    @verbatim
        <template id="select_category_tpl">
            <select v-model="note.category_id" class="form-control">
                <option value="">- Selecciona una categoría</option>
                <option v-for="category in categories" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </template>

        <template id="note_row_tpl">
            <tr>
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
        <template id="error_list_tpl">
            <ul v-if="errors.length" class="text-danger">
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </template>
    @endverbatim
    <script src="{{ asset('js/app.js') }}"></script>
@endsection