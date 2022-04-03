<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class insertWord extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_example()
    {
        $response=$this->getJson(route('word.list'));
        dd(($response->json()));
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
