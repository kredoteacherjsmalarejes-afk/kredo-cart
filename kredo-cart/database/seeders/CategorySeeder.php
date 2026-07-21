<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Travel',
                'description' => 'Explore the world and discover new places.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Food',
                'description' => 'Delicious recipes and culinary adventures.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Fashion',
                'description' => 'Latest trends and styles in fashion.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Fitness',
                'description' => 'Tips and workouts for a healthy lifestyle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Technology',
                'description' => 'Stay updated with the latest tech news and gadgets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Music',
                'description' => 'Discover new artists and enjoy your favorite tunes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Sports',
                'description' => 'Get the latest updates on your favorite sports and teams.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $this->category->insert($categories);
    }
}
