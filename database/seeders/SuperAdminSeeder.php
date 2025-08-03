<?php

namespace Database\Seeders;

use App\Models\Specialization;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'IT Department' => [
                'name' => 'Super Admin',
                'email' => 'vadmin@admin.com',
                'password' => Hash::make('Password@123'),
                'role_id' => 1,
                'status' => 'active'
            ]
        ];

        foreach ($users as $name => $data) {
            $specialization = Specialization::where('name', $name)->first();

            $data['specialization_id'] = $specialization->id;
            User::create($data);
        }

        $informations = [
            'Super Admin' => [
                'first_name' => 'vincent mark',
                'last_name' => 'carabbacan',
                'title' => 'Mr',
                'phone' => '12345678',
                'address' => 'Philippines',
                'birthdate' => '1992-03-15',
                'gender' => 'male',
                'bio' => 'Senior Web Developer',
                'experience_years' => 8,
                'is_visible' => true,
                'profile_photo' => 'https://i.pravatar.cc/300?img=15'

            ]
        ];

        foreach ($informations as $name => $data) {
            $user = User::where('name', $name)->first();

            if ($user) {
                UserInformation::create([
                    'user_id' => $user->id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'title' => $data['title'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'birthdate' => $data['birthdate'],
                    'gender' => $data['gender'],
                    'bio' => $data['bio'],
                    'experience_years' => $data['experience_years'],
                    'is_visible' => $data['is_visible'],
                    'profile_photo' => $data['profile_photo'],
                ]);
            }
        }
    }
}
