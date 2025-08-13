<?php

namespace Database\Seeders;

use App\Domain\ValueObjects\DateObj;
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
                'name' => 'Vincent Mark Carabbacan',
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
            'Vincent Mark Carabbacan' => [
                'first_name' => 'vincent mark',
                'last_name' => 'carabbacan',
                'title' => 'Mr',
                'phone' => '12345678',
                'address' => 'Philippines',
                'birthdate' => '1992-03-15',
                'gender' => 'male',
                'bio' => 'Senior Web Developer',
                'license_number' => '192-856526-1',
                'license_expiry' => '2027-03-05',
                'hired_date' => '2022-05-16',
                'is_visible' => true,
                'days_of_working' => 'Monday to Friday',
                'work_timing' => '9am - 5pm',
                'occupation_type' => 'Full-time',
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
                    'license_number' => $data['license_number'],
                    'license_expiry' => $data['license_expiry'],
                    'hired_date' => $data['hired_date'],
                    'is_visible' => $data['is_visible'],
                    'days_of_working' => $data['days_of_working'],
                    'work_timing' => $data['work_timing'],
                    'occupation_type' => $data['occupation_type'],
                    'profile_photo' => $data['profile_photo'],
                ]);
            }
        }
    }
}
