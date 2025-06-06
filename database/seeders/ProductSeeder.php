<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Running Tee',
            'href' => '#',
            'price' => 29.99,
            'color' => 'Sky Blue',
            'size' => 'M',
            'in_stock' => true,
            'image_src' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/category-page-04-image-card-01.jpg',
            'image_alt' => 'Light blue running t-shirt with breathable fabric.',
        ]);

        Product::create([
            'name' => 'Trail Shoes',
            'href' => '#',
            'price' => 89.90,
            'color' => 'Black/Red',
            'size' => '42',
            'in_stock' => true,
            'image_src' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-04-featured-product-shot.jpg',
            'image_alt' => 'Pair of black and red trail running shoes.',
        ]);

        Product::create([
            'name' => 'Training Shorts',
            'href' => '#',
            'price' => 24.50,
            'color' => 'Navy Blue',
            'size' => 'L',
            'in_stock' => false,
            'image_src' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/category-page-04-image-card-05.jpg',
            'image_alt' => 'Lightweight navy blue training shorts.',
        ]);

        Product::create([
            'name' => 'Fitness Jacket',
            'href' => '#',
            'price' => 65.00,
            'color' => 'Grey',
            'size' => 'XL',
            'in_stock' => true,
            'image_src' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-03-featured-product-shot.jpg',
            'image_alt' => 'Gray fitness jacket with zipper front and hood.',
        ]);
    }
}

