<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make("st123456");
        $gender = 'M';

        $students = [
            ['adm_no' => 7364, 'first_name' => 'Brian', 'last_name' => 'Kamau', 'classroom_id' => 1, 'year_admitted' => '2013-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7365, 'first_name' => 'James', 'last_name' => 'Mwangi', 'classroom_id' => 2, 'year_admitted' => '2014-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7366, 'first_name' => 'Kevin', 'last_name' => 'Odhiambo', 'classroom_id' => 3, 'year_admitted' => '2015-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7367, 'first_name' => 'Samuel', 'last_name' => 'Otieno', 'classroom_id' => 4, 'year_admitted' => '2016-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7368, 'first_name' => 'Joseph', 'last_name' => 'Ochieng', 'classroom_id' => 5, 'year_admitted' => '2013-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7369, 'first_name' => 'Peter', 'last_name' => 'Njoroge', 'classroom_id' => 1, 'year_admitted' => '2014-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7370, 'first_name' => 'Stephen', 'last_name' => 'Kipchirchir', 'classroom_id' => 2, 'year_admitted' => '2015-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7371, 'first_name' => 'Michael', 'last_name' => 'Njenga', 'classroom_id' => 3, 'year_admitted' => '2016-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7372, 'first_name' => 'Victor', 'last_name' => 'Ndungu', 'classroom_id' => 4, 'year_admitted' => '2013-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7373, 'first_name' => 'Daniel', 'last_name' => 'Mutua', 'classroom_id' => 5, 'year_admitted' => '2014-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7374, 'first_name' => 'Charles', 'last_name' => 'Karani', 'classroom_id' => 1, 'year_admitted' => '2015-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7375, 'first_name' => 'Patrick', 'last_name' => 'Kibet', 'classroom_id' => 2, 'year_admitted' => '2016-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7376, 'first_name' => 'Francis', 'last_name' => 'Nyaga', 'classroom_id' => 3, 'year_admitted' => '2013-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7377, 'first_name' => 'George', 'last_name' => 'Mutiso', 'classroom_id' => 4, 'year_admitted' => '2014-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7378, 'first_name' => 'Anthony', 'last_name' => 'Chege', 'classroom_id' => 5, 'year_admitted' => '2015-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7379, 'first_name' => 'Collins', 'last_name' => 'Koech', 'classroom_id' => 1, 'year_admitted' => '2016-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7380, 'first_name' => 'Elias', 'last_name' => 'Muriuki', 'classroom_id' => 2, 'year_admitted' => '2013-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7381, 'first_name' => 'Emmanuel', 'last_name' => 'Gatimu', 'classroom_id' => 3, 'year_admitted' => '2014-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7382, 'first_name' => 'Alfred', 'last_name' => 'Mwema', 'classroom_id' => 4, 'year_admitted' => '2015-10-17', 'gender' => $gender, 'password' => $password],
            ['adm_no' => 7383, 'first_name' => 'Tom', 'last_name' => 'Kariuki', 'classroom_id' => 5, 'year_admitted' => '2016-10-17', 'gender' => $gender, 'password' => $password],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
