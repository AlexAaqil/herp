<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class GuardianStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_records = [
            1 => [1, 1],
            2 => [2, 2],
            3 => [2, 3],
            4 => [3, 3],
        ];

        foreach ($data_records as $studentId => $guardianIds) {
            $student = Student::find($studentId);

            if ($student) {
                $student->guardians()->sync($guardianIds);
            }
        }
    }
}
