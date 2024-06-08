<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'product_name' => 'Chitato Rasa Sapi Panggang',
                // 'product_type' => 'snack',
                'product_price' => 16000,
                'expired_at' => '2024-12-12',
            ],
            [
                'product_name' => 'Japota Sapi Panggang',
                // 'product_type' => 'snack',
                'product_price' => 16000,
                'expired_at' => '2024-12-12',
            ],
            // [
            //     'product_name' => 'Sprite Rasa Lemon',
            //     'category_id' => 1,
            //     'product_price' => 7000,
            //     'expired_at' => '2024-12-12',
            // ],
        ];

        foreach ( $products as $product ) {
            Product::create( $product );
        }
    }
}
