<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'SEO記事',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'キャッチコピー',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'LP',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'メディア記事',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'シナリオ',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->category->insert($categories);
    }
}
