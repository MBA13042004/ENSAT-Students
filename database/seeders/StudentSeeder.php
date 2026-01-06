<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recreate the user's specific profile
        Student::updateOrCreate(
            ['email' => 'mossabbenabdellah7@gmail.com'],
            [
                'apogee' => '12345678', // Placeholder based on screenshot
                'cin' => 'K622160',
                'nom' => 'BEN ABDELLAH',
                'prenom' => 'MOSAB',
                'email' => 'mossabbenabdellah7@gmail.com',
                'filiere' => 'ginf',
                'niveau' => '2ème année', // Matching screenshot approximated
                'date_naissance' => '2000-01-01', // Dummy date
                'telephone' => '0600000000',
            ]
        );

        // Add some dummy students
        // Hiba Ben Adou (from user screenshot)
        Student::updateOrCreate(
            ['email' => 'bnbdallhmsb0@gmail.com'],
            [
                'apogee' => 'mon_code_apogee_2',
                'cin' => 'K622163',
                'nom' => 'BEN ADOU',
                'prenom' => 'HIBA',
                'email' => 'bnbdallhmsb0@gmail.com',
                'filiere' => 'ginf',
                'niveau' => '2ème année',
                'date_naissance' => '2000-01-01',
                'telephone' => '0600000002',
            ]
        );

        Student::updateOrCreate(
            ['email' => 'etudiant@ensat.ma'],
            [
                'apogee' => '20240001',
                'cin' => 'XA00001',
                'nom' => 'ETUDIANT',
                'prenom' => 'Test',
                'email' => 'etudiant@ensat.ma',
                'filiere' => 'ginf',
                'niveau' => '1ère année',
                'date_naissance' => '2002-05-15',
                'telephone' => '0611111111',
            ]
        );
    }
}
