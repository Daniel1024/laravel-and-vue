<?php

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;

    private $note = 'Esto es una nota';

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
        $this->post('api/v1/notes', [
            'note'          => '',
            'category_id'   => 100,
        ], ['Accept' => 'application/json']);

        $this->dontSeeInDatabase('notes', [
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
}
