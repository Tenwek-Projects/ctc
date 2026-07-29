@extends('layouts.app')

@section('title', 'Medical Education')

@php
    $metaDescription = $metaDescription ?? 'Medical education at AGC Tenwek Cardiothoracic Centre: COSECSA cardiothoracic surgery fellowship, perfusion training, anaesthesia rotations, and clinical learning grounded in excellence and Christian discipleship.';
    $canonicalUrl = route('training.medical-education', [], true);
@endphp

@push('head')
    <link rel="canonical" href="{{ $canonicalUrl }}">
@endpush

@section('content')
    @include('components.page-banner', [
        'title' => 'Medical Education',
        'subtitle' => 'Excellence in Training, Compassion in Service, Faith in Practice',
        'bannerKey' => 'training_medical_education',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Training & Research', 'url' => route('training-research')],
            ['label' => 'Medical Education', 'url' => route('training.medical-education')],
        ],
    ])

    <section class="py-14 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <article class="lg:col-span-8 ctc-service-category-prose prose prose-slate max-w-none text-[1.05rem]
                    prose-headings:font-headline prose-headings:tracking-tight prose-headings:text-ctc-blue
                    prose-h2:mt-10 prose-h2:mb-4 prose-h2:text-2xl sm:prose-h2:text-3xl
                    prose-h3:mt-8 prose-h3:mb-3 prose-h3:text-xl
                    prose-p:leading-relaxed prose-li:leading-relaxed
                    prose-a:text-ctc-secondary prose-a:no-underline hover:prose-a:underline">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent !mb-3 not-prose">Training &amp; Research</p>
                    <h1 class="!mt-0 !mb-3 text-3xl sm:text-4xl font-headline font-extrabold tracking-tight text-ctc-blue not-prose">
                        Medical Education
                    </h1>
                    <p class="text-lg sm:text-xl font-semibold text-ctc-ruby !mt-0 !mb-6 not-prose">
                        Excellence in Training, Compassion in Service, Faith in Practice
                    </p>

                    <p>The AGC Tenwek Cardiothoracic Centre (CTC) is committed to developing exceptional specialized healthcare professionals through excellence in clinical training, academic scholarship, research, innovation, and Christian discipleship.</p>
                    <p>As one of Africa's leading cardiothoracic centres, CTC offers comprehensive education across the continuum of cardiovascular and thoracic care. Our learners benefit from high clinical volumes, close faculty mentorship, multidisciplinary collaboration, and a Christ-centred learning environment that nurtures both professional competence and spiritual maturity.</p>
                    <p>Our philosophy is: <strong>train competent clinicians, develop compassionate leaders, and inspire faithful servants of Christ.</strong></p>

                    <h2>Educational Mission</h2>
                    <p>Our mission is to prepare healthcare professionals who provide safe, evidence-based, compassionate, and ethical care while demonstrating servant leadership and Christian values.</p>
                    <p>We seek to develop graduates who:</p>
                    <ul>
                        <li>Excel in clinical and surgical practice</li>
                        <li>Pursue lifelong learning</li>
                        <li>Lead multidisciplinary healthcare teams</li>
                        <li>Advance research and innovation</li>
                        <li>Serve resource-limited communities</li>
                        <li>Integrate Christian faith with professional excellence</li>
                        <li>Demonstrate integrity, humility, compassion, and stewardship</li>
                    </ul>

                    <h2>Training Programs</h2>

                    <h3>COSECSA-Accredited Cardiothoracic Surgery Fellowship (In Partnership with PAACS)</h3>
                    <p>The AGC Tenwek Cardiothoracic Centre (CTC) is a regional centre of excellence for multidisciplinary education in cardiovascular and thoracic care. Through rigorous clinical training, academic excellence, research, and Christian discipleship, we prepare Cardiothoracic surgery professionals to serve with competence, compassion, integrity, and a commitment to Christ-centred patient care.</p>
                    <p>Our flagship educational program is the COSECSA-accredited Cardiothoracic Surgery Fellowship, offered in partnership with the Pan-African Academy of Christian Surgeons (PAACS). The fellowship is designed for qualified general surgeons seeking advanced specialist training in cardiothoracic surgery through a structured, competency-based curriculum that combines high-volume clinical exposure, progressive operative responsibility, academic scholarship, and spiritual formation.</p>
                    <p>Upon successful completion of the fellowship and passing the College of Surgeons of East, Central and Southern Africa (COSECSA) Fellowship Examination, graduates are awarded the Fellow of the College of Surgeons in Cardiothoracic Surgery, an internationally recognized specialist qualification.</p>
                    <p>The fellowship emphasizes technical excellence, sound clinical judgment, professionalism, leadership, research, and Christian servant ministry, preparing graduates to become independent consultant cardiothoracic surgeons and future leaders in cardiovascular care across Africa and beyond.</p>
                    <p>The fellowship curriculum is based on the Society of Thoracic Surgeons (STS) Curriculum, providing trainees with a comprehensive, competency-based framework aligned with international best practices in cardiothoracic surgery. Fellows utilize the STS Cardiothoracic Surgery E-Book and other contemporary educational resources throughout their training, complemented by structured didactic teaching, simulation, operative mentoring, multidisciplinary case discussions, journal clubs, and regular formative assessments.</p>

                    <h3>Comprehensive Clinical Training</h3>
                    <p>Fellows receive extensive hands-on training across the full spectrum of cardiothoracic surgery, including:</p>
                    <ul>
                        <li>Adult cardiac surgery</li>
                        <li>Rheumatic heart disease surgery</li>
                        <li>Mitral and aortic valve repair and replacement</li>
                        <li>Coronary artery bypass grafting (CABG)</li>
                        <li>Minimally invasive cardiac surgery</li>
                        <li>Cardiac arrhythmia surgery</li>
                        <li>Aortic surgery</li>
                        <li>Thoracic surgery</li>
                        <li>Congenital cardiac surgery</li>
                        <li>Mechanical circulatory support (ECMO)</li>
                        <li>Cardiothoracic intensive care</li>
                        <li>Perioperative decision-making</li>
                        <li>Outpatient cardiothoracic clinics</li>
                        <li>Multidisciplinary Heart Team discussions</li>
                    </ul>
                    <p>Graduated responsibility, close faculty supervision, structured mentorship, and competency-based assessment ensure that fellows progressively develop the knowledge, technical skills, and professional judgment required for independent consultant practice.</p>

                    <h3>Fellowship Highlights</h3>
                    <ul>
                        <li>Curriculum based on the Society of Thoracic Surgeons (STS) Cardiothoracic Surgery Curriculum</li>
                        <li>Access to the STS Cardiothoracic Surgery E-Book and additional evidence-based educational resources</li>
                        <li>Weekly protected academic teaching sessions and structured didactic lectures</li>
                        <li>Regular journal clubs, case presentations, morbidity and mortality conferences, and multidisciplinary Heart Team meetings</li>
                        <li>Comprehensive preparation for the COSECSA Fellowship Examination</li>
                        <li>Competency-based curriculum aligned with international standards</li>
                        <li>High-volume exposure to adult cardiac, thoracic, and congenital cardiac surgery</li>
                        <li>Internationally recognized Fellowship qualification (FCS CTS [ECSA])</li>
                        <li>Extensive experience in rheumatic heart disease surgery and other cardiovascular conditions prevalent in low- and middle-income countries</li>
                        <li>Progressive operative responsibility under experienced consultant mentorship</li>
                        <li>Comprehensive education in perioperative care, critical care, and multidisciplinary decision-making</li>
                        <li>Integrated research training with opportunities for scientific publication and conference presentation</li>
                        <li>Christian discipleship, servant leadership, and professional development woven throughout the program</li>
                        <li>Preparation for leadership in clinical practice, education, research, and healthcare systems strengthening throughout Africa and globally</li>
                    </ul>

                    <h3>How to Apply</h3>
                    <p>Applications to the Cardiothoracic Surgery Fellowship are coordinated through the Pan-African Academy of Christian Surgeons (PAACS).</p>
                    <p>Prospective applicants should be qualified general surgeons who meet the eligibility requirements for admission into the COSECSA Cardiothoracic Surgery Fellowship Program.</p>
                    <p>For application requirements, deadlines, and additional information, please visit:</p>
                    <p><strong>PAACS:</strong> <a href="https://paacs.net" target="_blank" rel="noopener noreferrer">https://paacs.net</a></p>
                    <p>Applicants are encouraged to review the program requirements and submit their applications through the PAACS website. Shortlisted candidates will be contacted regarding the selection and interview process.</p>
                    <p>
                        <a href="{{ route('training.fellowship-rotations') }}" class="inline-flex items-center rounded-xl bg-ctc-blue px-5 py-3 text-sm font-semibold text-white no-underline hover:bg-ctc-blue-dark hover:text-white">
                            View fellowship programme page
                        </a>
                    </p>

                    <h3>Cardiovascular Perfusion Training Program</h3>
                    <p>CTC is proud to host a Cardiovascular Perfusion Training Program, preparing the next generation of cardiovascular perfusionists to support complex cardiac surgical procedures.</p>
                    <p>The curriculum includes:</p>
                    <ul>
                        <li>Cardiopulmonary bypass physiology</li>
                        <li>Perfusion technology</li>
                        <li>Extracorporeal circulation</li>
                        <li>Myocardial protection</li>
                        <li>Blood conservation</li>
                        <li>Mechanical circulatory support</li>
                        <li>ECMO principles</li>
                        <li>Perfusion safety and quality assurance</li>
                        <li>Simulation-based learning</li>
                        <li>Clinical rotations in the operating theatre and intensive care unit</li>
                    </ul>
                    <p>Graduates acquire the technical knowledge, clinical judgment, and professionalism required for modern perfusion practice.</p>
                    <p>
                        <a href="{{ route('training.perfusion') }}" class="inline-flex items-center rounded-xl border border-ctc-blue/20 bg-white px-5 py-3 text-sm font-semibold text-ctc-blue no-underline hover:bg-ctc-grey-light">
                            View perfusion programme page
                        </a>
                    </p>

                    <h3>Cardiac Anaesthesia Rotation</h3>
                    <p>The Centre provides specialized training and clinical rotations for anaesthesia residents and fellows with a focus on cardiovascular and thoracic anaesthesia.</p>
                    <p>Training includes:</p>
                    <ul>
                        <li>Preoperative assessment</li>
                        <li>Advanced hemodynamic monitoring</li>
                        <li>Transesophageal echocardiography (TEE) exposure</li>
                        <li>Cardiopulmonary bypass management</li>
                        <li>Cardiac critical care</li>
                        <li>One-lung ventilation</li>
                        <li>Thoracic anaesthesia</li>
                        <li>Congenital cardiac anaesthesia exposure</li>
                        <li>Postoperative ICU management</li>
                        <li>Pain management strategies</li>
                    </ul>
                    <p>Participants work alongside experienced cardiac anaesthesiologists as integral members of the Heart Team.</p>

                    <h3>Medical Student and Resident Rotations</h3>
                    <p>CTC welcomes undergraduate and postgraduate learners from partner institutions for elective and core clinical rotations.</p>
                    <p>Rotations include:</p>
                    <ul>
                        <li>Adult cardiac surgery</li>
                        <li>Thoracic surgery</li>
                        <li>Cardiac intensive care</li>
                        <li>Outpatient cardiothoracic clinics</li>
                        <li>Operating theatre experience</li>
                        <li>Ward-based learning</li>
                        <li>Research participation</li>
                    </ul>
                    <p>Students receive structured teaching while working alongside consultants, fellows, nurses, anaesthesiologists, and perfusionists.</p>

                    <h3>Critical Care Education</h3>
                    <p>The Cardiothoracic Intensive Care Unit offers multidisciplinary training for:</p>
                    <ul>
                        <li>Surgical residents</li>
                        <li>ICU nurses</li>
                        <li>Respiratory therapists</li>
                        <li>Clinical officers</li>
                    </ul>
                    <p>Areas of focus include:</p>
                    <ul>
                        <li>Mechanical ventilation</li>
                        <li>Hemodynamic support</li>
                        <li>Post-cardiac surgery critical care</li>
                        <li>ECMO principles</li>
                        <li>Renal replacement therapy</li>
                        <li>Sepsis management</li>
                        <li>Multiorgan failure</li>
                        <li>Point-of-care ultrasound</li>
                        <li>Emergency response</li>
                    </ul>

                    <h2>Clinical Learning Environment</h2>
                    <p>Education is integrated into every aspect of patient care.</p>
                    <p>Daily learning activities include:</p>
                    <ul>
                        <li>Consultant-led ward rounds</li>
                        <li>Operating room teaching</li>
                        <li>ICU rounds</li>
                        <li>Preoperative conferences</li>
                        <li>Postoperative reviews</li>
                        <li>Heart Team meetings</li>
                        <li>Imaging review sessions</li>
                        <li>Bedside teaching</li>
                        <li>Clinical case discussions</li>
                    </ul>
                    <p>Weekly academic activities include:</p>
                    <ul>
                        <li>Morbidity and mortality conferences</li>
                        <li>Journal clubs</li>
                        <li>Grand rounds</li>
                        <li>Surgical video reviews</li>
                        <li>Guideline updates</li>
                        <li>Faculty lectures</li>
                        <li>Visiting professor presentations</li>
                        <li>Simulation workshops</li>
                    </ul>

                    <h2>Surgical Skills and Simulation</h2>
                    <p>CTC promotes competency-based education through:</p>
                    <ul>
                        <li>Operative mentorship</li>
                        <li>Skills laboratories</li>
                        <li>Wet labs</li>
                        <li>Anastomosis simulation</li>
                        <li>Emergency procedure simulation</li>
                        <li>Crisis resource management</li>
                        <li>Perfusion simulation</li>
                        <li>Team-based simulation exercises</li>
                    </ul>
                    <p>Feedback is structured, individualized, and focused on progressive competence.</p>

                    <h2>Research and Innovation</h2>
                    <p>Every learner is encouraged to contribute to scientific advancement.</p>
                    <p>Educational opportunities include:</p>
                    <ul>
                        <li>Clinical research</li>
                        <li>Surgical outcomes research</li>
                        <li>Quality improvement</li>
                        <li>Clinical audits</li>
                        <li>Registry development</li>
                        <li>Systematic reviews</li>
                        <li>Case reports</li>
                        <li>Conference presentations</li>
                        <li>Manuscript writing</li>
                    </ul>
                    <p>Faculty mentor trainees from project conception through publication and presentation at national and international meetings.</p>

                    <h2>Visiting Professionals and International Partnerships</h2>
                    <p>CTC welcomes:</p>
                    <ul>
                        <li>Visiting surgeons</li>
                        <li>Fellows</li>
                        <li>Residents</li>
                        <li>Cardiologists</li>
                        <li>Anaesthesiologists</li>
                        <li>Perfusionists</li>
                        <li>Nurses</li>
                        <li>Researchers</li>
                        <li>Medical students</li>
                        <li>Allied health professionals</li>
                    </ul>
                    <p>Visitors may participate in:</p>
                    <ul>
                        <li>Clinical observerships</li>
                        <li>Hands-on educational experiences (as permitted)</li>
                        <li>Research collaborations</li>
                        <li>Surgical workshops</li>
                        <li>Teaching exchanges</li>
                        <li>Community outreach</li>
                        <li>Global health initiatives</li>
                    </ul>
                    <p>Our international partnerships foster knowledge exchange, collaborative research, faculty development, and capacity building while strengthening cardiovascular care across Africa.</p>

                    <h2>Why Train at CTC?</h2>
                    <p>The AGC Tenwek Cardiothoracic Centre offers a distinctive educational experience through:</p>
                    <ul>
                        <li>High-volume exposure to complex cardiac and thoracic diseases</li>
                        <li>Comprehensive multidisciplinary training programs</li>
                        <li>Accredited perfusion education</li>
                        <li>Specialized cardiac anaesthesia and critical care rotations</li>
                        <li>Thoracic endoscopy and bronchoscopy training</li>
                        <li>Strong academic and research mentorship</li>
                        <li>State-of-the-art clinical learning environment</li>
                        <li>International faculty collaboration</li>
                        <li>Competency-based education</li>
                        <li>Christian mentorship and spiritual formation</li>
                        <li>A culture of servant leadership, compassion, and excellence</li>
                    </ul>
                    <p>If you are aspiring to become a Cardiothoracic surgeon, anaesthesiologist, perfusionist, nurse, researcher, student, or allied health professional, CTC provides an exceptional environment for professional, academic, and spiritual growth while preparing you to transform cardiovascular care in Africa and beyond.</p>
                </article>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-24 space-y-5">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="border-b border-gray-100 bg-ctc-blue px-5 py-5 sm:px-6">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Also explore</p>
                                <h3 class="mt-2 text-lg font-headline font-extrabold tracking-tight text-white">
                                    Related pathways
                                </h3>
                                <p class="mt-1.5 text-sm text-white/70 leading-relaxed">
                                    Programme pages, research, and ways to get in touch.
                                </p>
                            </div>
                            <nav class="divide-y divide-gray-100" aria-label="Related pathways">
                                <a href="{{ route('training.fellowship-rotations') }}" class="group flex items-start gap-3 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 group-hover:text-ctc-blue">Cardiothoracic Surgery Fellowship</span>
                                        <span class="mt-1 block text-xs text-gray-500">PAACS · COSECSA</span>
                                    </span>
                                </a>
                                <a href="{{ route('training.perfusion') }}" class="group flex items-start gap-3 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 group-hover:text-ctc-blue">Perfusion Training</span>
                                        <span class="mt-1 block text-xs text-gray-500">Classroom, simulation, and clinical practice</span>
                                    </span>
                                </a>
                                <a href="{{ route('research') }}" class="group flex items-start gap-3 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 group-hover:text-ctc-blue">Research</span>
                                        <span class="mt-1 block text-xs text-gray-500">Outcomes, innovation, and scholarship</span>
                                    </span>
                                </a>
                                <a href="{{ route('contact') }}" class="group flex items-start gap-3 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 group-hover:text-ctc-blue">Contact Us</span>
                                        <span class="mt-1 block text-xs text-gray-500">Ask about rotations and visiting programmes</span>
                                    </span>
                                </a>
                            </nav>
                        </div>
                        <a href="https://paacs.net" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center rounded-xl bg-ctc-ruby px-5 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-ctc-ruby/90 transition-colors">
                            Apply via PAACS
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
