<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/contact');

        $response->assertStatus(200);
    }

    public function test_store_contact(Type $var = null)
    {
        $data = [
            'name' => 'kecesafas',
            'email' => 'kecsafsfe@gmail.com',
            'phone' => '21312321'
        ];
        $response = $this->post('/api/contact', $data);
        $response->assertStatus(200);
    }
}
