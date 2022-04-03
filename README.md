#here is the live url for this projecct 
https://ebizcard.tech/pseudo/public
#here is the git repo for this project
https://github.com/samir480/pseudo


i have developed api in laravel and front end in html css 
i have done the main task that is test all api using TDD 


here is the code for TDD
from the rood directory :tests\Feature\AllWrodTest.php



#here is code  tests\Feature\AllWrodTest.php

<?php

namespace Tests\Feature;

use App\Models\WordModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllWrodTest extends TestCase
{
    use RefreshDatabase;

    private $list;
    public function setUp(): void
    {
        parent::setUp();
        $this->list = WordModel::factory()->create(['word' => 'My First Word']);
    }
    public function test_get_all_words()
    {
        //prepare
        WordModel::factory(10)->create();
        //perform
        $response = $this->getJson(route('word.list'));
        //predict
        $this->assertEquals(1, $response->json()['status']);
    }
    public function test_get_data_by_id()
    {
        //prepare
        WordModel::factory(10)->create();
        //perform
        $response = $this->getJson(route('word.detail', 5))->assertOk()->json();
        //predict
        $this->assertEquals(1, $response['status']);
    }
    public function test_insert_word()
    {
        //prepare

        //perform
        $response = $this->postJson(route('word.create'), ['word' => 'testing'])
            ->assertCreated();
        //predict
        $this->assertDatabaseHas('word_models', ['word' => 'testing']);
    }
    public function test_update_word()
    {
        //prepare

        //perform
         $this->patchJson(route('word.update',$this->list->id),['word' => 'updated word']);
        //predict
        $this->assertDatabaseHas('word_models', ['id'=>$this->list->id,'word' => 'updated word']);
    }
    public function test_delete_word()
    {
        //prepare

        //perform
         $this->deleteJson(route('word.delete',$this->list->id))
            ->assertNoContent();
        //predict
        $this->assertDatabaseMissing('word_models', ['word' => $this->list->word]);
    }
   


    
}
