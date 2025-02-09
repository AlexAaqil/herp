<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(ClassroomCategorySeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(GuardianSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(GuardianStudentSeeder::class);
    }
}
