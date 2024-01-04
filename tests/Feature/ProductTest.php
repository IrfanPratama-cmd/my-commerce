<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetProducts()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $product = [
            'category_id' => Str::uuid(),
            'brand_id' => Str::uuid(),
            'product_code' => 'Test',
            'product_name' => 'Test Name',
            'stock' => 5,
            'price' => 10000
        ];

        $response = $this->get('/products', $product);

        $response->assertStatus(200);
        $response->assertViewIs('product.index');
        $response->assertViewHas('page', 'Master Data Product');

        Product::where('product_code', 'Test')->delete();
    }

    // public function testStoreProducts()
    // {
    //     $controller = new ProductController(); // Ganti dengan nama controller Anda
    //     $requestData = [
    //         'category_id' => Str::uuid(),
    //         'brand_id' => Str::uuid(),
    //         'product_code' => 'Test',
    //         'product_name' => 'Test Name',
    //         'stock' => 5,
    //         'price' => 10000
    //     ];

    //     $request = new Request($requestData);
    //     $response = $controller->store($request);
    //     $response->assertRedirect('/')
    //         ->assertSessionHas('success', 'Product created successfully');

    //     // $this->assertDatabaseHas('product', $requestData); // Memastikan data tersimpan di database
    //     // $this->assertEquals(200, $response->getStatusCode()); // Memastikan response code adalah 200
    //     // $this->assertJson($response->getContent()); // Memastikan response adalah JSON
    //     // $this->assertEquals('Product created successfully', json_decode($response->getContent())->success); // Memastikan pesan sukses sesuai

    //     Product::where('product_code', 'Test')->delete();
    // }

    // public function testEditCategories()
    // {
    //     $data = [
    //         'category_code' => 'ABC',
    //         'category_name' => 'Test category'
    //     ];


    //     $controller = new CategoryController();

    //     $request = new Request($data);
    //     $response = $controller->store($request);

    //     $this->assertDatabaseHas('category', $data);

    //     $category = Category::where('category_code', 'ABC')->first();

    //     $response = $controller->edit($category->id);
    //     $this->assertInstanceOf(JsonResponse::class, $response);
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $categoryData = json_decode($response->getContent(), true);
    //     $this->assertNotNull($categoryData);

    //     $this->assertEquals($category->id, $categoryData['id']);

    //     $category->delete();
    // }

    public function testDeleteProducts()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        $requestData = [
            'category_id' => Str::uuid(),
            'brand_id' => Str::uuid(),
            'product_code' => 'Test',
            'product_name' => 'Test Name',
            'stock' => 5,
            'price' => 10000
        ];

        $product = Product::create($requestData);
        $response = $this->delete("/products/{$product->id}");

         // Assert
        $response->assertStatus(200)
        ->assertJson(['response' => 'Product deleted successfully.']);
    }
}
