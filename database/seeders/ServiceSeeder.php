<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'category' => Service::CATEGORY_CARDIAC,
                'name' => 'Adult Cardiology',
                'slug' => 'adult-cardiology',
                'sort_order' => 1,
                'description' => <<<'HTML'
<p>Our Adult Cardiology service focuses on the prevention, diagnosis, and treatment of cardiovascular diseases affecting adults. Our cardiologists work closely with patients to develop individualized treatment plans aimed at improving heart health and enhancing quality of life.</p>
<p><strong>Services include:</strong></p>
<ul>
<li>Cardiology consultations</li>
<li>Heart disease screening and prevention</li>
<li>Hypertension management</li>
<li>Heart failure management</li>
<li>Echocardiography</li>
<li>Stress testing</li>
<li>Electrocardiography (ECG)</li>
<li>Holter monitoring</li>
<li>Cardiac risk assessment</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_CARDIAC,
                'name' => 'Pediatric Cardiology',
                'slug' => 'pediatric-cardiology',
                'sort_order' => 2,
                'description' => <<<'HTML'
<p>Our Pediatric Cardiology team provides specialized care for infants, children, and adolescents with congenital and acquired heart conditions. We partner closely with families to ensure children receive expert care from diagnosis through adulthood when needed.</p>
<p><strong>Services include:</strong></p>
<ul>
<li>Congenital heart disease diagnosis</li>
<li>Foetal and paediatric echocardiography</li>
<li>Outpatient consultations</li>
<li>Long-term follow-up care</li>
<li>Preventive cardiac care</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_CARDIAC,
                'name' => 'Cardiac Surgery',
                'slug' => 'cardiac-surgical-care',
                'sort_order' => 3,
                'description' => <<<'HTML'
<p>Our experienced cardiothoracic surgeons perform a wide range of adult and pediatric cardiac procedures using modern surgical techniques supported by advanced perioperative care.</p>
<p><strong>Procedures include:</strong></p>
<ul>
<li>Coronary artery bypass grafting (CABG)</li>
<li>Heart valve repair and replacement</li>
<li>Surgery for congenital heart defects</li>
<li>Aortic surgery</li>
<li>Cardiac tumor surgery</li>
<li>Redo cardiac surgery</li>
</ul>
<p>Every surgical patient is supported by a multidisciplinary team including cardiac anaesthesiologists, perfusionists, intensivists, specialized nurses, physiotherapists, nutritionists, and rehabilitation specialists.</p>
HTML,
            ],
            [
                'category' => Service::CATEGORY_CARDIAC,
                'name' => 'Cardiac Catheterization Laboratory (Cath Lab)',
                'slug' => 'cardiac-catheterization-laboratory',
                'sort_order' => 4,
                'description' => <<<'HTML'
<p>Our state-of-the-art Cardiac Catheterization Laboratory provides minimally invasive diagnostic and interventional procedures for the treatment of cardiovascular disease.</p>
<p><strong>Our Cath Lab services include:</strong></p>
<ul>
<li>Coronary angiography</li>
<li>Coronary angioplasty (PCI)</li>
<li>Peripheral angiography and angioplasty</li>
<li>Right and left heart catheterization</li>
<li>Congenital heart defect closures (ASD/VSD)</li>
<li>Balloon pulmonary valvuloplasty</li>
<li>Pacemaker implantation</li>
<li>Implantable cardioverter-defibrillator (ICD) implantation</li>
<li>Cardiac resynchronization therapy (CRT)</li>
<li>Transcatheter Aortic Valve Implantation (TAVI/TAVR)</li>
<li>IVC filter insertion and removal</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_THORACIC,
                'name' => 'Thoracic Surgery',
                'slug' => 'thoracic-surgical-care',
                'sort_order' => 5,
                'description' => <<<'HTML'
<ul>
<li>We provide comprehensive surgical care for diseases affecting the lungs, chest wall, mediastinum, diaphragm, and oesophagus.</li>
<li>Our surgeons manage both benign and complex thoracic conditions using evidence-based surgical techniques aimed at achieving the best possible outcomes while minimizing recovery time.</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_DIAGNOSTICS,
                'name' => 'Endoscopy',
                'slug' => 'endoscopy',
                'sort_order' => 6,
                'description' => <<<'HTML'
<p>Our Endoscopy Unit offers both diagnostic and therapeutic gastrointestinal procedures using modern endoscopic technology.</p>
<p><strong>Services include:</strong></p>
<ul>
<li>Upper gastrointestinal endoscopy (EGD)</li>
<li>Colonoscopy</li>
<li>Endoscopic Ultrasound (EUS)</li>
<li>ERCP</li>
<li>Cancer screening</li>
<li>Polypectomy</li>
<li>Biopsy procedures</li>
<li>Therapeutic endoscopic interventions</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_DIAGNOSTICS,
                'name' => 'Diagnostic Imaging',
                'slug' => 'diagnostic-imaging',
                'sort_order' => 7,
                'description' => <<<'HTML'
<p>Accurate diagnosis is the foundation of effective treatment. Our imaging department provides advanced diagnostic services that support timely clinical decision-making.</p>
<p><strong>Available services include:</strong></p>
<ul>
<li>CT Scanning</li>
<li>Echocardiography</li>
<li>Ultrasound</li>
<li>Digital X-ray</li>
<li>Fluoroscopy</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_DIAGNOSTICS,
                'name' => 'Laboratory Services',
                'slug' => 'laboratory-services',
                'sort_order' => 8,
                'description' => <<<'HTML'
<p>Our modern laboratory provides comprehensive diagnostic testing to support clinical care across all specialties.</p>
<p><strong>Services include:</strong></p>
<ul>
<li>Clinical Chemistry</li>
<li>Haematology</li>
<li>Microbiology</li>
<li>Histopathology</li>
<li>Immunohistochemistry</li>
<li>Cytology</li>
<li>Blood Transfusion Services</li>
<li>Molecular Diagnostics</li>
</ul>
HTML,
            ],
            [
                'category' => Service::CATEGORY_CARDIAC,
                'name' => 'Intensive Care Unit (ICU)',
                'slug' => 'intensive-care-unit',
                'sort_order' => 9,
                'description' => <<<'HTML'
<p>Our specialized Intensive Care Unit provides continuous monitoring and advanced critical care for patients recovering from major cardiac and thoracic procedures or those with life-threatening conditions.</p>
<p>Our highly trained multidisciplinary team is available around the clock to ensure patients receive the highest standard of intensive care throughout their recovery.</p>
HTML,
            ],
        ];

        $slugs = [];

        foreach ($services as $data) {
            $slug = $data['slug'] ?? Str::slug($data['name']);
            $slugs[] = $slug;

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'category' => $data['category'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'sort_order' => $data['sort_order'],
                    'slug' => $slug,
                    'is_visible' => true,
                    'show_on_homepage' => true,
                ]
            );
        }

        // Hide legacy demo services that are no longer part of this catalogue.
        Service::query()
            ->whereNotIn('slug', $slugs)
            ->update(['is_visible' => false]);
    }
}
