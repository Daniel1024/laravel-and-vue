@extends('layout')

@section('content')
    <div class="container" style="background-color: white">
        <div class="row" id="app">
            <div class="col-md-8 col-md-offset-2">
                <h1>Curso de VueJS</h1>
                <div class="alert_container">
                    <transition name="bounce">
                        <p v-if="alert.display" class="alert alert-danger">
                            @{{ alert.message }}
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
                <hr>
                <pre>@{{ $data }}</pre>
            </div>
        </div>
    </div>
@endsection