<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Dr Russell Eli White',
                'credentials' => 'MD, MPH, FACS, FCS (ECSA)',
                'title' => 'Senior Director',
                'team_group' => 'senior_leadership',
                'specialization' => 'Cardiothoracic Surgery',
                'bio' => 'Senior Director of the Cardiothoracic Centre, leading clinical excellence, training, and regional capacity building.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dr. John Kamau',
                'credentials' => 'MD, FCS (ECSA)',
                'title' => 'Director, Cardiothoracic Centre',
                'team_group' => 'cardiothoracic_centre',
                'specialization' => 'Adult & Pediatric Cardiac Surgery',
                'bio' => 'Dr. Kamau leads the CTC with over 20 years of experience in cardiac surgery. He has trained surgeons across East Africa and is committed to expanding access to life-saving heart surgery.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Dr. Grace Wanjiku',
                'credentials' => 'MD, FCS (ECSA)',
                'title' => 'Consultant Cardiothoracic Surgeon',
                'team_group' => 'cardiothoracic_surgeons',
                'specialization' => 'Valve Surgery & Coronary Artery Bypass',
                'bio' => 'Dr. Wanjiku specializes in complex valve repair and replacement, as well as coronary artery bypass grafting. She is actively involved in fellowship training.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Dr. Peter Ochieng',
                'credentials' => 'MD',
                'title' => 'Consultant Thoracic Surgeon',
                'team_group' => 'cardiothoracic_surgeons',
                'specialization' => 'Lung Surgery & Chest Tumors',
                'bio' => 'Dr. Ochieng leads the thoracic surgery program, with expertise in lung resection, mediastinal conditions, and chest wall reconstruction.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Dr. Mary Akinyi',
                'credentials' => 'MD',
                'title' => 'Pediatric Cardiac Surgeon',
                'team_group' => 'paediatric_cardiologist',
                'specialization' => 'Congenital Heart Disease',
                'bio' => 'Dr. Akinyi is dedicated to caring for children with congenital heart defects. She has helped establish pediatric cardiac services across the region.',
                'sort_order' => 5,
            ],
        ];

        foreach ($members as $data) {
            TeamMember::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'slug' => Str::slug($data['name']),
                    'photo' => null,
                    'is_visible' => true,
                ])
            );
        }
    }
}
