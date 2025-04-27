<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function __construct(Client $client){
        $this->client = $client;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => '〇〇株式会社',
                'description' => 'marumaru@gmail.com',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '株式会社〇〇',
                'description' => 'チャットワークで連絡',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '田中様',
                'description' => 'LINEで連絡',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => '佐藤様',
                'description' => 'ランサーズで連絡',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->client->insert($clients);
    }
}
