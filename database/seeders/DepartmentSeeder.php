<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Medical & Clinical Departments',
                'description' => 'Medical & Clinical Departments provide specialized care, diagnosis, and treatment across various fields of medicine.',
            ],
            [
                'name' => 'Diagnostic & Laboratory Departments',
                'description' => 'Diagnostic & Laboratory Departments perform tests and analyses to support accurate diagnosis, treatment, and monitoring of medical conditions.',
            ],
            [
                'name' => 'Emergency & Critical Care',
                'description' => 'Emergency & Critical Care Departments provide immediate treatment for severe injuries, illnesses, and life-threatening conditions.',
            ],
            [
                'name' => 'Support & Allied Health Services',
                'description' => 'Support & Allied Health Services offer essential non-clinical care, aiding diagnosis, recovery, and overall patient well-being.',
            ],
            [
                'name' => 'Administrative & Non-Clinical Departments',
                'description' => 'Administrative & Non-Clinical Departments manage operations, finance, HR, and logistics to ensure smooth and efficient healthcare delivery.',
            ],
        ];

        foreach ($departments as $data) {
            Department::create($data);
        }
    }
}
