<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categoryName = [
            'Machine Learning',
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Artificial Intelligence',
            'Cyber Security',
            'Cloud Computing',
            'DevOps',
            'Blockchain',
            'Internet of Things',
        ];

        for ($i = 0; $i < 10; $i++) {
            DB::table('categories')->insert([
                'name' => $categoryName[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
