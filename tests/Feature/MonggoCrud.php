<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MonggoCrud extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/customer');
        $response->assertStatus(200);
    }

    public function test_store_data()
    {
        $data = [
            'name' => 'kece',
            'email' => 'kece@gmail.com',
        ];
        $response = $this->post('/api/customer', $data);
        $response->assertStatus(200)->assertJson($data);
    }
}
