<?php

namespace Database\Seeders;

use App\Models\Course;
use Cancionistica\ValueObjects\ImageSize;
use Carbon\Carbon;
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
                "email_verified_at" => Carbon::now()
            ],[
                "id" => Uuid::uuid(),
                "name" => "Mario Bros",
                "email" => "mario@bros.com",
                "password" => bcrypt("11111111"),
                "email_verified_at" => Carbon::now()
            ],[
                "id" => Uuid::uuid(),
                "name" => "TETE4700609",
                "email" => "test_user_38642520@testuser.com",
                "password" => bcrypt("11111111"),
                "email_verified_at" => Carbon::now()
            ],[
                "id" => Uuid::uuid(),
                "name" => "TESTJTYPXFL5",
                "email" => "test_user_79249952@testuser.com",
                "password" => bcrypt("11111111"),
                "email_verified_at" => Carbon::now()
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
        Course::factory(4)->create()->each(function(Course $course, int $index){
            $imageIndex = $index + 1;
            $course->images()->create([
                "path" => "images/courses/cancionistica-{$imageIndex}.jpg",
                "size" => ImageSize::FULL
            ]);
            $course->images()->create([
                "path" => "images/courses/cancionistica-{$imageIndex}-thumb.jpg",
                "size" => ImageSize::THUMBNAIL
            ]);
        });
    }
}
