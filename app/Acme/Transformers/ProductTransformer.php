<?php namespace app\Acme\Transformers;

class ProductTransformer extends Transformer
{
    public function transform($product)
    {
        $category = [];
        if (isset($product['category'])) {
            $category = [
                'title' => $product['category']['name'],
                'id' => $product['category']['id'],
            ];
        }

        $data = [
            'title' => $product['name'],
            'id' => $product['id']
        ];

        if ($category) {
            $data['category'] = $category;
        } else {
            $data['category_id'] = $product['category_id'];
        }

        return $data;
    }
}
