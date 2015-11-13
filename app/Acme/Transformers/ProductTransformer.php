<?php namespace App\Acme\Transformers;

class ProductTransformer extends Transformer
{

	public function transform($product)
    {
        return [
            'title' => $product['name'],
            'id' => $product['id']
        ];
    }

}