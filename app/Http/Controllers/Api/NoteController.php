<?php

namespace App\Http\Controllers\Api;

use App\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Note::all();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'note'          => 'required',
            'category_id'   => 'exists:categories,id'
        ]);

        //$data = $request->only(['note', 'category_id']);
        $category_id = null;
        if ($request->get('category_id')!='') {
            $category_id = $request->get('category_id');
        }
        $note = new Note();
        $note->note = $request->get('note');
        $note->category_id = $category_id;
        $note->save();

        return [
            'success'   => true,
            'note'      => $note->toArray()
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Note $note
     * @return array
     */
    public function update(Request $request, Note $note)
    {
        $this->validate($request, [
            'note'          => 'required',
            'category_id'   => 'exists:categories,id'
        ]);

        $category_id = null;
        if ($request->get('category_id')!='') {
            $category_id = $request->get('category_id');
        }

        $note->note = $request->get('note');
        $note->category_id = $category_id;
        $note->save();

        return [
            'success'   => true,
            'note'      => $note->toArray()
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Note $note
     * @return array
     */
    public function destroy(Note $note)
    {
        //abort(500, 'cualquier mensaje');
        $note->delete();
        return [
            'success' => true
        ];
    }
}
