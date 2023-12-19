<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndexReturnsView()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);
        // Replace with the appropriate namespace for your Brand model and controller
        $brand = [
            'brand_code' => 'Test',
            'brand_name' => 'Test Name',
        ];

        $response = $this->get('/brands', $brand); // Replace '/brand' with your actual route

        $response->assertStatus(200);
        $response->assertViewIs('brand.index'); // Replace 'brand.index' with your actual view name
        $response->assertViewHas('page', 'Master Data Brand');
    }
}
