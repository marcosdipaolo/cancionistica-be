<?php

namespace Database\Seeders;

use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "id" => Uuid::uuid(),
                "name" => config("app.admin.name"),
                "email" => config("app.admin.email"),
                "password" => bcrypt("11111111"),
            ],[
                "id" => Uuid::uuid(),
                "name" => "Mario Bros",
                "email" => "mario@bros.com",
                "password" => bcrypt("11111111")
            ],
        ]);
        DB::table("post_categories")->insert([
            [
                "id" => Uuid::uuid(),
                "name" => "música en vivo",
            ],
            [
                "id" => Uuid::uuid(),
                "name" => "talleres",
            ]
        ]);
    }
}
