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

        $data = $request->only(['note', 'category_id']);

        $note = Note::create($data);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
