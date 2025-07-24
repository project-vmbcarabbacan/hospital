<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            'Medical & Clinical Departments' => [
                ['name' => 'General Medicine / Internal Medicine', 'description' => 'Diagnosis and non-surgical treatment of diseases in adults'],
                ['name' => 'General Surgery', 'description' => 'Surgical procedures not specific to one organ or system'],
                ['name' => 'Pediatrics', 'description' => 'Medical care of infants, children, and adolescents'],
                ['name' => 'Obstetrics and Gynecology (OB/GYN)', 'description' => 'Pregnancy, childbirth, and female reproductive health'],
                ['name' => 'Orthopedics', 'description' => 'Bone, joint, and musculoskeletal disorders'],
                ['name' => 'Cardiology', 'description' => 'Heart and blood vessel disorders'],
                ['name' => 'Neurology', 'description' => 'Disorders of the nervous system (brain, spine, nerves)'],
                ['name' => 'Dermatology', 'description' => 'Skin, hair, and nail disorders'],
                ['name' => 'ENT (Otorhinolaryngology)', 'description' => 'Ear, Nose, and Throat disorders'],
                ['name' => 'Ophthalmology', 'description' => 'Eye care and vision-related treatments'],
                ['name' => 'Urology', 'description' => 'Urinary tract and male reproductive system'],
                ['name' => 'Nephrology', 'description' => 'Kidney-related diseases and dialysis'],
                ['name' => 'Gastroenterology', 'description' => 'Digestive system and gastrointestinal tract'],
                ['name' => 'Pulmonology', 'description' => 'Respiratory system and lung conditions'],
                ['name' => 'Oncology', 'description' => 'Cancer diagnosis and treatment'],
                ['name' => 'Endocrinology', 'description' => 'Hormonal and glandular disorders (e.g., diabetes, thyroid)'],
            ],
            'Diagnostic & Laboratory Departments' => [
                ['name' => 'Radiology / Imaging', 'description' => 'X-ray, CT, MRI, ultrasound, etc.'],
                ['name' => 'Pathology / Clinical Laboratory', 'description' => 'Blood tests, biopsies, histopathology'],
            ],
            'Emergency & Critical Care' => [
                ['name' => 'Emergency Department (ER)', 'description' => 'Acute care and trauma handling'],
                ['name' => 'ICU / Intensive Care Unit', 'description' => 'Critical care for life-threatening conditions'],
                ['name' => 'NICU / Neonatal ICU', 'description' => 'Intensive care for newborns'],
            ],
            'Support & Allied Health Services' => [
                ['name' => 'Pharmacy', 'description' => 'Medication dispensing and consultation'],
                ['name' => 'Physiotherapy / Rehabilitation', 'description' => 'Physical therapy and recovery support'],
                ['name' => 'Nutrition & Dietetics', 'description' => 'Clinical nutrition plans and diet consultations'],
                ['name' => 'Anesthesiology', 'description' => 'Pain management and surgical anesthesia'],
            ],
            'Administrative & Non-Clinical Departments' => [
                ['name' => 'Outpatient Department (OPD)', 'description' => 'Walk-in consultations and follow-ups'],
                ['name' => 'Inpatient Department (IPD)', 'description' => 'Admitted patient management'],
                ['name' => 'Medical Records / HIM', 'description' => 'Health information management and record-keeping'],
                ['name' => 'Billing & Insurance', 'description' => 'Financial processing, claims, co-payments'],
                ['name' => 'Customer Relations / Helpdesk', 'description' => 'Patient services and queries'],
                ['name' => 'IT Department', 'description' => 'Hospital software and infrastructure management'],
                ['name' => 'HR & Recruitment', 'description' => 'Staffing, hiring, employee records'],
            ],
        ];

        foreach ($specializations as $departmentName => $specs) {
            $department = Department::where('name', $departmentName)->first();

            foreach ($specs as $spec) {
                Specialization::create([
                    'department_id' => $department->id,
                    'name' => $spec['name'],
                    'description' => $spec['description'],
                    'photo' => 'default.jpg', // Optional
                ]);
            }
        }
    }
}
