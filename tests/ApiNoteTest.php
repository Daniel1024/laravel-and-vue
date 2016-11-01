<?php

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_notes()
    {
        $category = factory(Category::class)->create();

        $notes = factory(Note::class)->times(2)->create([
            'category_id' => $category->id
        ]);

        $this->get('api/v1/notes')
            ->assertResponseOk()
            ->seeJson($notes->toArray());
    }
}
