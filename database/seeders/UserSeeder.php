<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->user->name = 'masa';
        $this->user->email = 'masa@gmail.com';
        $this->user->password = Hash::make('asdfasdf');
        $this->user->save();
    }
}
