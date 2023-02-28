<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    protected $model = \App\Models\Book::class;

    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Book::factory(100)->create();
        $this->call(UsersTableSeeder::class);
    }
}
