<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ensat.ma'],
            [
                'name' => 'Administrator ENSAT',
                'email' => 'admin@ensat.ma',
                'role' => 'ADMIN',
                'password' => bcrypt('admin123'), // Default password
                'firebase_uid' => null, // Will be set on first Firebase login
            ]
        );
    }
}
