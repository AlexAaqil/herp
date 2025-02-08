<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classrooms\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = [
            [
                'name' => '1 South',
                'classroom_category_id' => 1,
                'class_teacher_id' => 3,
            ],
            [
                'name' => '1 North',
                'classroom_category_id' => 1,
                'class_teacher_id' => 4,
            ],
            [
                'name' => '2 South',
                'classroom_category_id' => 2,
                'class_teacher_id' => 4,
            ],
            [
                'name' => '3 South',
                'classroom_category_id' => 3,
                'class_teacher_id' => 5,
            ],
            [
                'name' => '4 South',
                'classroom_category_id' => 4,
                'class_teacher_id' => 5,
            ],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::create($classroom);
        }
    }
}
