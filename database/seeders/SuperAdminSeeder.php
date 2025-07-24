<?php

namespace Database\Seeders;

use App\Models\Specialization;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'email' => 'super@admin.com',
                'password' => 'tl01ksm29as',
                'role_id' => 1,
                'status' => 'active'
            ]
        ];

        foreach($users as $name => $data) {
            $specialization = Specialization::where('name', $name)->first();

            $data['specialization_id'] = $specialization->id;
            User::create($data);
        }

        $informations = [
            'Super Admin' => [
                'phone' => '12345678',
                'address' => 'Philippines',
                'birthdate' => '1992-03-15',
                'gender' => 'male',
                'profile_photo' => 'default.png'

            ]
        ];

        foreach($informations as $name => $data) {
            $user = User::where('name', $name)->first();

            if($user) {
                UserInformation::create([
                    'user_id' => $user->id,
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'birthdate' => $data['birthdate'],
                    'gender' => $data['gender'],
                    'profile_photo' => $data['profile_photo'],
                ]);
            }
        }
    }
}
