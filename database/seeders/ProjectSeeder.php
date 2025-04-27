<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function __construct(Project $project){
        $this->project = $project;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Project A',
                'status' => '受注',
                'description' => 'Description for Project A',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'title' => 'Project B',
                'status' => '受注',
                'description' => 'Description for Project B',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'title' => 'Project C',
                'status' => '受注',
                'description' => 'Description for Project C',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'title' => 'Project D',
                'status' => '受注',
                'description' => 'Description for Project D',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'title' => 'Project F',
                'status' => '受注',
                'description' => 'Description for Project F',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'title' => 'Project G',
                'status' => '受注',
                'description' => 'Description for Project G',
                'received_date' => Carbon::now()->subDays(10),
                'temp_deadline' => Carbon::now()->addDays(10),
                'deadline' => Carbon::now()->addDays(30),
                'temp_pay_date' => Carbon::now()->addDays(5),
                'cost_per_character' => 100,
                'deadline_character' => 5000,
                'temp_salary' => 50000,
                'user_id' => 1,  // Assumes user with ID 1 exists
                'client_id' => 1, // Assumes client with ID 1 exists
                'category_id' => 1, // Assumes category with ID 1 exists
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ];

        $this->project->insert($projects);
    }
}
