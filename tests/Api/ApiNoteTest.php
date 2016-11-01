<?php

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;

    private $note = 'Esto es una nota';
    private $updateNote = 'Actualizando una nota';

    function test_list_notes()
    {
        $category = factory(Category::class)->create();

        $notes = factory(Note::class)->times(2)->create([
            'category_id' => $category->id
        ]);

        $this->get('api/v1/notes')
            ->assertResponseOk()
            ->seeJson($notes->toArray());
    }

    function test_can_create_a_note()
    {
        $category = factory(Category::class)->create();

        $this->post('api/v1/notes', [
            'note'          => $this->note,
            'category_id'   => $category->id
        ], ['Accept' => 'application/json']);

        $this->seeInDatabase('notes', [
            'note'          => $this->note,
            'category_id'   => $category->id
        ]);

        $this->seeJson([
            'success'   => true,
            'note'      => Note::first()->toArray(),
        ]);
    }

    function test_validation_when_creating_a_note()
    {
        //$categoy = factory(Category::class)->create();
        $this->post('api/v1/notes', [
            'note'          => '',
            'category_id'   => 458,
        ], ['Accept' => 'application/json']);

        $this->dontSeeInDatabase('notes', [
            'note'          => '',
            'category_id'   => 458,
        ]);

        $this->seeJson([
            'success'   => false,
            'errors'   => [
                'The note field is required.',
                'The selected category is invalid.'
            ]
        ]);
    }

    function test_can_update_a_note()
    {
        $category = factory(Category::class)->create();
        $anotherCategory = factory(Category::class)->create();

        $note = factory(Note::class)->make();

        $category->notes()->save($note);

        $this->put('api/v1/notes/'.$note->id, [
            'note'          => $this->updateNote,
            'category_id'   => $anotherCategory->id
        ], ['Accept' => 'application/json']);

        $this->seeInDatabase('notes', [
            'note'          => $this->updateNote,
            'category_id'   => $anotherCategory->id
        ]);

        $this->seeJson([
            'success'   => true,
            'note'      => [
                'id'            => $note->id,
                'note'          => $this->updateNote,
                'category_id'   => $anotherCategory->id
            ],
        ]);
    }

    function test_validation_when_updating_a_note()
    {
        $category = factory(Category::class)->create();

        $note = factory(Note::class)->make();

        $category->notes()->save($note);

        $this->put('api/v1/notes/'.$note->id, [
            'note'          => '',
            'category_id'   => 100,
        ], ['Accept' => 'application/json']);

        $this->dontSeeInDatabase('notes', [
            'id'            => $note->id,
            'note'          => '',
            'category_id'   => 100,
        ]);

        $this->seeJson([
            'success'   => false,
            'errors'   => [
                'The note field is required.',
                'The selected category is invalid.'
            ]
        ]);
    }

    function test_can_delete_a_note()
    {
        $note = factory(Note::class)->create();

        $this->delete('api/v1/notes/'.$note->id, [],
            ['Accept' => 'application/json']
        );

        $this->dontSeeInDatabase('notes', $note->toArray());

        $this->seeJson([
            'success'   => true,
        ]);
    }

}
