<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Http\Request;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetCategories()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $category = [
            'category_code' => 'Test',
            'category_name' => 'Test Name',
        ];

        $response = $this->get('/categories', $category);

        $response->assertStatus(200);
        $response->assertViewIs('category.index');
        $response->assertViewHas('page', 'Master Data Category');
    }

    public function testStoreCategories()
    {
        $controller = new CategoryController(); // Ganti dengan nama controller Anda
        $requestData = [
            'category_code' => 'ABC',
            'category_name' => 'Test category'
        ];

        $request = new Request($requestData);
        $response = $controller->store($request);

        $this->assertDatabaseHas('category', $requestData); // Memastikan data tersimpan di database
        $this->assertEquals(200, $response->getStatusCode()); // Memastikan response code adalah 200
        $this->assertJson($response->getContent()); // Memastikan response adalah JSON
        $this->assertEquals('Category saved successfully.', json_decode($response->getContent())->success); // Memastikan pesan sukses sesuai

        Category::where('category_code', 'ABC')->delete();
    }

    public function testEditCategories()
    {
        $data = [
            'category_code' => 'ABC',
            'category_name' => 'Test category'
        ];


        $controller = new CategoryController();

        $request = new Request($data);
        $response = $controller->store($request);

        $this->assertDatabaseHas('category', $data);

        $category = Category::where('category_code', 'ABC')->first();

        $response = $controller->edit($category->id);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $categoryData = json_decode($response->getContent(), true);
        $this->assertNotNull($categoryData);

        $this->assertEquals($category->id, $categoryData['id']);

        $category->delete();
    }

    public function testDeleteCategories()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $requestData = [
            'category_code' => 'DEF',
            'category_name' => 'Test category'
        ];

        $category = Category::create($requestData);
        $response = $this->delete("/categories/{$category->id}");

         // Assert
        $response->assertStatus(200)
        ->assertJson(['response' => 'Category deleted successfully.']);
    }
}
