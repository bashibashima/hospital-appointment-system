<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            'Cardiologist',
            'Dermatologist',
            'Pediatrician',
            'Gynecologist',
            'Neurologist',
            'Orthopedic',
            'Psychiatrist',
            'Dentist',
        ];

        foreach ($specializations as $name) {
            Specialization::create(['name' => $name]);
        }
    }
}


