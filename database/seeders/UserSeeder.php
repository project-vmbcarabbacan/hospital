<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeders = [
            [
                "role" => 2,
                "count" => 2
            ],
            [
                "role" => 3,
                "count" => 16
            ],
            [
                "role" => 4,
                "count" => 30
            ],
            [
                "role" => 5,
                "count" => 10
            ],
            [
                "role" => 6,
                "count" => 18
            ],
            [
                "role" => 7,
                "count" => 9
            ],
            [
                "role" => 8,
                "count" => 8
            ],
            [
                "role" => 9,
                "count" => 2
            ],
            [
                "role" => 10,
                "count" => 2
            ],
            [
                "role" => 11,
                "count" => 150
            ],
            [
                "role" => 12,
                "count" => 3
            ],
        ];

        foreach ($seeders as $seed) {
            $this->createSeederByRole($seed['role'], $seed['count']);
        }
    }

    private function createSeederByRole($role, $count = 10)
    {
        User::factory()
            ->count($count)
            ->state([
                'role_id' => $role,
                'password' => bcrypt('Password@123')
            ])
            ->create()
            ->each(function ($user) {
                $info = UserInformation::factory()->create([
                    'user_id' => $user->id,
                ]);

                $user->update([
                    'name' => $info->first_name . ' ' . $info->last_name,
                ]);
            });
    }
}
