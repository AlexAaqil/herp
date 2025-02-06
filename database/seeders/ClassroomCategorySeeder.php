<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classrooms\ClassroomCategory;

class ClassroomCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classroom_categories = [
            'Form 1',
            'Form 2',
            'Form 3',
            'Form 4',
        ];

        foreach ($classroom_categories as $category) {
            ClassroomCategory::create([
                'name' => $category,
            ]);
        }
    }
}
