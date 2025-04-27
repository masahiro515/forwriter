<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkType;

class WorkTypeSeeder extends Seeder
{
    private $work_type;

    public function __construct(WorkType $work_type){
        $this->work_type = $work_type;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $work_types = [
            [
                'name' => 'リサーチ',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '構成',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '執筆',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '入稿',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->work_type->insert($work_types);
    }
}
