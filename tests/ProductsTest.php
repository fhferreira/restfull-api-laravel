<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends ApiTester
{
    /** @test */
    public function it_fetches_products()
    {
        //arrange
        $this->times(5)->makeProduct();
        //act
        $this->getJson("api/v1/product");
        //asset
        $this->assertResponseOk();
    }

    private function makeProduct($productFields = [])
    {
        $product = array_merge([
            'name' => $this->fake->name,
            'category_id' =>rand(1, 10)
        ], $productFields);

        while ($this->times--) {
            App\Product::create($product);
        }
    }
}
