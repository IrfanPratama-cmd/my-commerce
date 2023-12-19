<?php

namespace Tests\Feature;

use App\Http\Controllers\BrandController;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Http\Request;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetBrands()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $brand = [
            'brand_code' => 'Test',
            'brand_name' => 'Test Name',
        ];

        $response = $this->get('/brands', $brand); // Replace '/brand' with your actual route

        $response->assertStatus(200);
        $response->assertViewIs('brand.index'); // Replace 'brand.index' with your actual view name
        $response->assertViewHas('page', 'Master Data Brand');
    }

    public function testStoreBrands()
    {
        $controller = new BrandController(); // Ganti dengan nama controller Anda
        $requestData = [
            'brand_code' => 'ABC',
            'brand_name' => 'Test Brand'
        ];

        $request = new Request($requestData);
        $response = $controller->store($request);

        $this->assertDatabaseHas('brand', $requestData); // Memastikan data tersimpan di database
        $this->assertEquals(200, $response->getStatusCode()); // Memastikan response code adalah 200
        $this->assertJson($response->getContent()); // Memastikan response adalah JSON
        $this->assertEquals('Brand saved successfully.', json_decode($response->getContent())->success); // Memastikan pesan sukses sesuai

        Brand::where('brand_code', 'ABC')->delete();
    }

    public function testEditBrands()
    {
        $data = [
            'brand_code' => 'ABC',
            'brand_name' => 'Test Brand'
        ];

        // Membuat instance dari Controller
        $controller = new BrandController();

        $request = new Request($data);
        $response = $controller->store($request);

        $this->assertDatabaseHas('brand', $data); // Memastikan data tersimpan di database

        $brand = Brand::where('brand_code', 'ABC')->first();

        // Memanggil metode edit dengan parameter ID
        $response = $controller->edit($brand->id);

        // Memeriksa apakah response merupakan instance dari JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Memeriksa apakah response memiliki status code 200 (OK)
        $this->assertEquals(200, $response->getStatusCode());

        // Memeriksa apakah response berisi data brand yang sesuai dengan ID yang diharapkan
        $brandData = json_decode($response->getContent(), true);
        $this->assertNotNull($brandData);

        $this->assertEquals($brand->id, $brandData['id']);
        // Jika ada field lain yang diharapkan, bisa ditambahkan pemeriksaan di sini

        $brand->delete();
    }

    public function testDeleteBrands()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $requestData = [
            'brand_code' => 'DEF',
            'brand_name' => 'Test Brand'
        ];

        $brand = Brand::create($requestData);
        $response = $this->delete("/brands/{$brand->id}");

         // Assert
        $response->assertStatus(200)
        ->assertJson(['response' => 'Brand deleted successfully.']);
    }
}
