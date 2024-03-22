<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = \App\Models\Category::pluck('id');

        foreach (range(1, 10) as $index) {
            $imageWidth = 400;
            $imageHeight = 300;

            // $response = Http::withoutVerifying()->get("https://lorempixel.com/{$imageWidth}/{$imageHeight}/", [
            //     'allow_redirects' => false, 
            // ]);


            // $imagePath = $this->saveImage($response->header('Location'));

            DB::table('courses')->insert([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'image' => null,
                'category_id' => $categories->random(),
                'price' => $faker->randomFloat(2, 10, 100),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function saveImage($imageUrl)
    {
        if (empty($imageUrl)) {
            return null;
        }

        $fileName = 'image_' . time() . '_' . rand(1000, 9999) . '.jpg'; 
        $filePath = 'images/' . $fileName; 
        $imageContent = file_get_contents($imageUrl);

        if ($imageContent === false) {
            return null; 
        }

        Storage::put($filePath, $imageContent);

        return $filePath;
    }

}
