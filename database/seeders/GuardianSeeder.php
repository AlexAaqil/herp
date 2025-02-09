<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guardian;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardians = [
            [
                'first_name' => 'Silvia',
                'last_name' => 'Njeri',
                'email' => 'parent@gmail.com',
                'phone_number' => '0720569458',
            ],
            [
                'first_name' => 'Beatrice',
                'last_name' => 'Wangari',
                'email' => 'parent1@gmail.com',
                'phone_number' => '0746055487',
            ],
            [
                'first_name' => 'Nicholas',
                'last_name' => 'Kamau',
                'email' => 'parent2@gmail.com',
                'phone_number' => '0720569457',
            ],
            [
                'first_name' => 'Charles',
                'last_name' => 'Maina',
                'email' => 'parent3@gmail.com',
                'phone_number' => '0720569358',
            ],
        ];

        foreach($guardians as $guardian) {
            Guardian::create($guardian);
        }
    }
}
