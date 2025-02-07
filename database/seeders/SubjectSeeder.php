<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'Maths',
            'English',
            'Kiswahili',
            'Biology',
            'Chemistry',
            'Physics',
            'Geography',
            'History',
            'CRE',
            'Agriculture',
            'Business Studies',
            'Computer Studies',
            'P.E',
            'Home Science',
            'Life Skills',
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject,
            ]);
        }
    }
}
