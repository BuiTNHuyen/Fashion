<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Origin;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // $categoryIds = [8, 9, 10, 11, 13, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 26, 27, 28, 29];

        return [
            'brand_id' => rand(1, 10),
            // 'category_id' => $this->faker->randomElement($categoryIds),
            'origin_id' => rand(1, 8),
            'name' => collect([
                'Áo thun', 'Áo sơ mi', 'Quần jeans', 'Áo khoác', 'Váy', 'Chân váy', 'Quần short', 'Đầm', 'Balo', 'Túi xách', 'Mũ', 'Thắt lưng'])
                ->random(). ' '. collect(['nam', 'nữ'])
                ->random(). ' '. collect(['cotton', 'jeans', 'kaki', 'polyester', 'len', 'da'])
                ->random(). ' '. collect(['trắng', 'đen', 'xanh', 'đỏ', 'vàng', 'hồng', 'nâu'])
                ->random(). ' '. str_pad($this->faker->unique()->numberBetween(1, 100), 3, '0', STR_PAD_LEFT),
            'product_code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'price' => $this->faker->randomElement([
                100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000,
                550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000
            ]),
            'discount' => 0,
            'quantity' => $this->faker->numberBetween(10, 100),
            'sold' => $this->faker->numberBetween(0, 50),
            'description' => $this->faker->paragraphs(3, true),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
} 