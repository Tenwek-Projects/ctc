<?php

namespace Database\Seeders;

use App\Models\DepartmentPage;
use Illuminate\Database\Seeder;

class DepartmentPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->definitions() as $row) {
            $segment = $row['url_segment'];
            $data = collect($row)->except('url_segment')->all();
            DepartmentPage::updateOrCreate(
                ['url_segment' => $segment],
                array_merge(['url_segment' => $segment], $data)
            );
        }
    }

    private function definitions(): array
    {
        return [
            [
                'url_segment' => 'cardiology',
                'admin_label' => 'Cardiology Department',
                'meta_title' => 'Cardiology Department',
                'meta_description' => 'Adult cardiology at AGC Tenwek Cardiothoracic Centre: prevention, diagnosis, and treatment of heart and vascular disease with echocardiography, ECG, stress testing, and multidisciplinary care in Bomet, Kenya.',
                'intro_kicker' => 'Clinical care',
                'intro_heading' => 'Cardiology Department',
                'intro_subheading' => 'Comprehensive, patient-centered care for adults with cardiovascular disease at AGC Tenwek Cardiothoracic Centre',
                'sort_order' => 10,
                'is_visible' => true,
                'body_html' => <<<'HTML'
<h2>Overview</h2>
<p>The Cardiology Department at AGC Tenwek Cardiothoracic Centre provides comprehensive, patient-centered care for adults with cardiovascular diseases. Our team is dedicated to the prevention, diagnosis, treatment, and long-term management of heart and vascular conditions using evidence-based medicine and advanced diagnostic technologies. We work closely with cardiothoracic surgeons, pediatric cardiologists, the cardiac catheterization laboratory, pharmacy, and other specialties to ensure coordinated, multidisciplinary care.</p>

<h2>Conditions Managed</h2>
<p>We diagnose and treat a wide range of cardiovascular conditions, including:</p>
<ul>
<li>Hypertension (high blood pressure)</li>
<li>Coronary artery disease (angina and heart attacks)</li>
<li>Heart failure</li>
<li>Cardiac valve diseases</li>
<li>Cardiac arrhythmias (irregular heart rhythms)</li>
<li>Cardiomyopathies</li>
<li>Pericardial diseases</li>
<li>Congenital heart disease in adults</li>
<li>Pulmonary hypertension</li>
<li>Dyslipidemia</li>
<li>Syncope (fainting) and unexplained dizziness</li>
</ul>

<h2>Signs and Symptoms</h2>
<p>Patients should seek medical evaluation or be referred if they experience:</p>
<ul>
<li>Chest pain or chest discomfort</li>
<li>Shortness of breath</li>
<li>Palpitations or irregular heartbeat</li>
<li>Fainting or dizziness</li>
<li>Swelling of the legs or abdomen</li>
<li>Persistent fatigue or reduced exercise tolerance</li>
<li>Uncontrolled high blood pressure</li>
<li>Heart murmurs</li>
<li>Previous heart attack or stroke requiring ongoing cardiac care</li>
</ul>

<h2>Diagnostic Services</h2>
<p>Our department offers comprehensive cardiovascular assessment, including:</p>
<ul>
<li>Specialist cardiology consultation</li>
<li>Electrocardiogram (ECG)</li>
<li>Transthoracic echocardiography (cardiac ultrasound)</li>
<li>Transoesophageal echocardiography</li>
<li>Exercise stress testing</li>
<li>48-hour Holter ECG monitoring</li>
<li>Laboratory evaluation for cardiovascular risk</li>
<li>Advanced cardiac imaging and cardiac catheterization when indicated</li>
</ul>

<h2>Treatment and Services</h2>
<p>We provide:</p>
<ul>
<li>Medical management of acute and chronic cardiovascular diseases</li>
<li>Optimization of heart failure therapy</li>
<li>Hypertension and lipid management</li>
<li>Prevention of cardiovascular disease</li>
<li>Pre-operative cardiac assessment</li>
<li>Lifestyle and risk-factor counseling</li>
<li>Referral for coronary angiography, coronary intervention, pacemaker implantation, structural heart procedures, or cardiothoracic surgery when appropriate</li>
</ul>

<h2>Patient Journey</h2>
<p>Patients begin with a comprehensive consultation that includes medical history, physical examination, and review of previous investigations. Appropriate diagnostic tests are arranged, followed by an individualized treatment plan. Patients receive education about their condition, medications, lifestyle modifications, and follow-up care. Those requiring specialized procedures are referred seamlessly within the Centre for advanced interventions or surgery.</p>

<h2>Referral Information</h2>
<p>Healthcare providers should refer patients with:</p>
<ul>
<li>Suspected or confirmed heart disease</li>
<li>Persistent or unexplained chest pain</li>
<li>Heart failure symptoms</li>
<li>Significant arrhythmias or palpitations</li>
<li>Heart valve disease</li>
<li>Resistant hypertension</li>
<li>Abnormal ECG or echocardiogram findings</li>
<li>Syncope of suspected cardiac origin</li>
<li>Patients requiring pre-operative cardiac assessment or specialist opinion</li>
</ul>
<p>Urgent referrals are encouraged for patients with suspected acute coronary syndrome, decompensated heart failure, life-threatening arrhythmias, or other cardiac emergencies.</p>

<h2>Specialized Services</h2>
<ul>
<li>Comprehensive adult cardiology consultation</li>
<li>Advanced echocardiography services</li>
<li>Non-invasive cardiac investigations</li>
<li>Multidisciplinary heart team approach</li>
<li>Close collaboration with the Cardiac Catheterization Laboratory and Cardiothoracic Surgery teams</li>
<li>Evidence-based management aligned with international cardiovascular guidelines</li>
</ul>

<h2>Frequently Asked Questions</h2>
<h3>Do I need a referral to see a cardiologist?</h3>
<p>Patients may be referred by a healthcare provider, although direct appointments may also be available according to hospital policy.</p>
<h3>What should I bring to my appointment?</h3>
<p>Please bring previous medical records, medication lists, ECGs, echocardiograms, laboratory results, and any relevant imaging.</p>
<h3>Will all tests be done on the same day?</h3>
<p>Many investigations can be performed during the same visit, while others may be scheduled depending on availability and clinical urgency.</p>
<h3>Will I need surgery?</h3>
<p>Most heart conditions can initially be managed with medications and lifestyle changes. Surgery or catheter-based procedures are recommended only when clinically indicated.</p>

<h2>Our Commitment</h2>
<p>Our mission is to provide compassionate, high-quality cardiovascular care through clinical excellence, innovation, education, and teamwork. We are committed to improving the heart health of our patients and communities by delivering timely, evidence-based, and personalized care.</p>
HTML,
            ],
            [
                'url_segment' => 'cardiothoracic-surgery',
                'admin_label' => 'Cardiothoracic Surgery Department',
                'meta_title' => 'Cardiothoracic Surgery Department',
                'meta_description' => 'Cardiothoracic surgery at AGC Tenwek Cardiothoracic Centre: adult and congenital heart surgery, thoracic and vascular procedures, CICU care, and regional referral services for Kenya and East Africa.',
                'intro_kicker' => 'Surgical care',
                'intro_heading' => 'Cardiothoracic Surgery Department',
                'intro_subheading' => 'Comprehensive surgical care for diseases of the heart, lungs, chest, and major blood vessels',
                'sort_order' => 20,
                'is_visible' => true,
                'body_html' => <<<'HTML'
<h2>Overview</h2>
<p>The Cardiothoracic Surgery Department at the AGC Tenwek Cardiothoracic Centre provides comprehensive surgical care for diseases of the heart, lungs, chest, and major blood vessels. We serve patients from Kenya and across East and Central Africa, offering advanced cardiac, thoracic, congenital heart, and vascular surgery.</p>
<p>Our mission is to provide high-quality, compassionate, and affordable care while training the next generation of African cardiothoracic surgeons and advancing research that improves patient outcomes. Our multidisciplinary team includes cardiothoracic surgeons, cardiologists, anesthesiologists, intensivists, perfusionists, specialized nurses, physiotherapists, nutritionists, and other healthcare professionals who work together to deliver individualized care.</p>
<p>The Centre combines modern technology with a patient-centered approach, ensuring that every patient receives comprehensive evaluation, treatment, rehabilitation, and long-term follow-up.</p>

<h2>Conditions we treat</h2>
<h3>Adult cardiac conditions</h3>
<p>We provide surgical treatment for a wide range of heart diseases, including:</p>
<ul>
<li>Rheumatic heart valve disease</li>
<li>Degenerative mitral and aortic valve disease</li>
<li>Infective endocarditis</li>
<li>Coronary artery disease requiring coronary artery bypass grafting (CABG)</li>
<li>Aortic aneurysms and aortic dissections</li>
<li>Cardiac tumors</li>
<li>Pericardial diseases</li>
<li>Heart failure requiring surgical intervention</li>
<li>Complications of previous cardiac surgery</li>
</ul>

<h3>Congenital heart disease</h3>
<p>Our congenital heart surgery program treats children and adults born with heart defects, including:</p>
<ul>
<li>Atrial septal defects (ASD)</li>
<li>Ventricular septal defects (VSD)</li>
<li>Atrioventricular septal defects (AVSD)</li>
<li>Tetralogy of Fallot (TOF)</li>
<li>Patent ductus arteriosus (PDA)</li>
<li>Coarctation of the aorta</li>
<li>Anomalous pulmonary venous return (APVR)</li>
<li>Pulmonary valve abnormalities</li>
</ul>

<h3>Thoracic conditions</h3>
<p>Our thoracic surgery team manages diseases affecting the lungs, chest wall, mediastinum, diaphragm, and esophagus, including:</p>
<ul>
<li>Lung cancer</li>
<li>Benign lung tumors</li>
<li>Pleural diseases</li>
<li>Empyema</li>
<li>Aspergilloma</li>
<li>Pneumothorax</li>
<li>Chest trauma</li>
<li>Mediastinal masses</li>
<li>Chest wall tumors</li>
<li>Diaphragmatic disorders</li>
<li>Esophageal problems (tumors, motility disorders, strictures, perforations)</li>
</ul>

<h3>Vascular conditions</h3>
<p>We also perform surgery for selected vascular diseases, including:</p>
<ul>
<li>Aortic aneurysms</li>
<li>Aortic dissections</li>
<li>Peripheral artery aneurysms</li>
<li>Vascular trauma</li>
<li>Dialysis access surgery</li>
</ul>

<h2>When should you seek medical attention?</h2>
<p>Patients should seek medical evaluation if they experience symptoms such as:</p>
<h3>Adult heart disease</h3>
<ul>
<li>Chest pain or pressure</li>
<li>Shortness of breath</li>
<li>Easy fatigue</li>
<li>Swelling of the legs</li>
<li>Palpitations</li>
<li>Fainting episodes</li>
<li>Heart murmurs</li>
<li>Blue discoloration of the lips or fingers (especially in children)</li>
</ul>
<h3>Congenital heart disease</h3>
<ul>
<li>Poor feeding</li>
<li>Failure to gain weight</li>
<li>Frequent chest infections</li>
<li>Bluish discoloration</li>
<li>Fast breathing</li>
<li>Excessive sweating during feeding</li>
<li>Delayed growth</li>
</ul>
<h3>Lung and chest conditions</h3>
<ul>
<li>Persistent cough</li>
<li>Coughing blood</li>
<li>Chest pain</li>
<li>Difficulty breathing</li>
<li>Recurrent chest infections</li>
<li>Persistent fluid around the lungs</li>
<li>Chest wall swelling</li>
<li>Difficulty swallowing</li>
</ul>

<h2>Diagnostic services</h2>
<p>Our comprehensive diagnostic services include:</p>
<h3>Cardiac imaging</h3>
<ul>
<li>Transthoracic echocardiography</li>
<li>Transesophageal echocardiography</li>
<li>Stress echocardiography</li>
<li>Cardiac CT scanning</li>
</ul>
<h3>Cardiac catheterization</h3>
<ul>
<li>Coronary angiography</li>
<li>Right and left heart catheterization</li>
<li>Diagnostic congenital heart catheterization</li>
</ul>
<h3>Thoracic diagnostics</h3>
<ul>
<li>Chest X-ray</li>
<li>CT scan</li>
<li>Bronchoscopy</li>
<li>Pulmonary function testing</li>
</ul>
<h3>Laboratory services</h3>
<ul>
<li>Blood investigations</li>
<li>Infection screening</li>
<li>Pre-operative assessment</li>
</ul>

<h2>Treatments and procedures</h2>
<h3>Adult cardiac surgery</h3>
<ul>
<li>Mitral valve repair and replacement</li>
<li>Aortic valve repair and replacement</li>
<li>Tricuspid valve repair and replacement</li>
<li>Multiple valve surgery</li>
<li>Coronary artery bypass grafting (CABG)</li>
<li>Ascending, arch, descending, thoraco-abdominal, and abdominal aortic surgery</li>
<li>Aortic root replacement</li>
<li>Pericardiectomy</li>
<li>Cardiac tumor excision</li>
<li>Redo cardiac surgery</li>
</ul>
<h3>Congenital heart surgery</h3>
<p>We perform repair of both simple and complex congenital heart defects, including infant, pediatric, and adult congenital procedures.</p>
<h3>Thoracic surgery</h3>
<ul>
<li>Esophagectomy</li>
<li>Esophageal myotomy</li>
<li>Lung resections</li>
<li>Decortication</li>
<li>Pleural surgery</li>
<li>Mediastinal tumor excision</li>
<li>Chest wall reconstruction</li>
<li>Thoracoscopic surgery (where appropriate)</li>
</ul>
<h3>Vascular surgery</h3>
<ul>
<li>Aortic surgery</li>
<li>Dialysis access creation</li>
<li>Vascular trauma surgery</li>
</ul>

<h2>What to expect during your care</h2>
<h3>Initial consultation</h3>
<p>Patients are evaluated by a specialist who reviews medical history, symptoms, previous investigations, and physical examination. Additional tests may be ordered before treatment recommendations are made.</p>
<h3>Pre-operative assessment</h3>
<p>Patients undergo laboratory tests, imaging studies, anesthesia assessment, medical optimization, and counseling regarding surgery and recovery.</p>
<h3>Surgery</h3>
<p>Our operations are performed by experienced cardiothoracic surgeons using modern operating theatres equipped with advanced technology and supported by specialized cardiac anesthesia, perfusion, and nursing teams.</p>
<h3>Intensive care</h3>
<p>Following surgery, patients recover in our dedicated Cardiothoracic Intensive Care Unit (CICU), where they receive continuous monitoring and specialized postoperative care.</p>

<h2>Recovery and rehabilitation</h2>
<p>Recovery includes:</p>
<ul>
<li>Pain management</li>
<li>Physiotherapy</li>
<li>Respiratory therapy</li>
<li>Nutrition support</li>
<li>Medication education</li>
<li>Lifestyle counseling</li>
</ul>

<h2>Follow-up</h2>
<p>Patients receive regular follow-up visits to monitor recovery, optimize medications, and ensure long-term health.</p>

<h2>Referral information</h2>
<p>Healthcare providers should consider referral for patients with:</p>
<h3>Adult cardiac disease</h3>
<ul>
<li>Severe valve disease</li>
<li>Symptomatic coronary artery disease</li>
<li>Aortic aneurysms</li>
<li>Cardiac tumors</li>
<li>Recurrent heart failure due to structural heart disease</li>
</ul>
<h3>Congenital heart disease</h3>
<ul>
<li>Newly diagnosed congenital heart defects</li>
<li>Cyanotic heart disease</li>
<li>Heart murmurs requiring specialist evaluation</li>
<li>Children with poor growth and suspected heart disease</li>
<li>Adults with congenital heart disease requiring surgical assessment</li>
</ul>
<h3>Thoracic disease</h3>
<ul>
<li>Esophageal problems</li>
<li>Lung masses</li>
<li>Persistent pleural disease</li>
<li>Recurrent pneumothorax</li>
<li>Chest wall tumors</li>
<li>Mediastinal masses</li>
</ul>
<h3>Emergency referrals</h3>
<p>Urgent referral is recommended for:</p>
<ul>
<li>Acute aortic dissection</li>
<li>Leaking aneurysms</li>
<li>Cardiac tamponade</li>
<li>Mechanical complications following heart attack</li>
<li>Severe infective endocarditis with heart failure</li>
<li>Major chest and vascular trauma requiring surgical management</li>
</ul>

<h2>Specialized services</h2>
<ul>
<li>Comprehensive adult and congenital cardiac surgery</li>
<li>Rheumatic heart disease surgery</li>
<li>Valve repair and reconstruction</li>
<li>Complex aortic surgery</li>
<li>Advanced thoracic surgery</li>
<li>Multidisciplinary heart team approach</li>
<li>Dedicated cardiothoracic intensive care unit</li>
<li>Cardiac catheterization laboratory</li>
<li>ECMO (Extracorporeal Membrane Oxygenation) for severe heart and lung failure</li>
<li>Fellowship training in cardiothoracic surgery</li>
<li>Regional referral centre serving East and Central Africa</li>
<li>Ongoing clinical research and quality improvement initiatives</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Do I need surgery immediately after diagnosis?</h3>
<p>Not always. Some conditions require monitoring, while others benefit from early surgical treatment. Your surgeon will discuss the best timing based on your condition.</p>
<h3>How long will I stay in the hospital?</h3>
<p>Hospital stay depends on the procedure performed and your recovery. Most cardiac surgery patients stay approximately one to two weeks.</p>
<h3>Can children undergo heart surgery safely?</h3>
<p>Yes. Many congenital heart defects can be successfully repaired with excellent long-term outcomes when treated by experienced teams.</p>
<h3>Will I need lifelong follow-up?</h3>
<p>Some conditions require lifelong specialist follow-up, while others may only require periodic review.</p>
<h3>Is heart surgery safe?</h3>
<p>Modern heart surgery is very safe, although every operation carries risks. Your surgeon will explain the expected benefits and potential risks before surgery.</p>
<h3>Can patients from outside Kenya receive treatment?</h3>
<p>Yes. We regularly care for patients from many countries across Africa and assist with coordinating referrals and appointments.</p>
<h3>What should I bring to my appointment?</h3>
<p>Please bring previous medical records, imaging studies, laboratory results, referral letters, and a list of your current medications.</p>

<h2>Why choose AGC Tenwek Cardiothoracic Centre?</h2>
<ul>
<li>Experienced multidisciplinary team</li>
<li>Comprehensive care for adults and children</li>
<li>Modern operating theatres and intensive care facilities</li>
<li>Commitment to compassionate, patient-centered care</li>
<li>Internationally recognized training and research programs</li>
<li>Affordable, high-quality cardiac and thoracic surgical services</li>
<li>Regional referral center serving patients throughout East and Central Africa</li>
</ul>
HTML,
            ],
            [
                'url_segment' => 'endoscopy',
                'admin_label' => 'Endoscopy Department',
                'meta_title' => 'Endoscopy Department',
                'meta_description' => 'Endoscopy at AGC Tenwek Cardiothoracic Centre: EGD, colonoscopy, bronchoscopy, EUS, and ERCP for diagnosis and treatment of digestive and respiratory conditions in Bomet, Kenya.',
                'intro_kicker' => 'Diagnostics & therapy',
                'intro_heading' => 'Endoscopy Department',
                'intro_subheading' => 'Diagnostic exams, therapeutic procedures, and disease screening using advanced endoscopic technology',
                'sort_order' => 30,
                'is_visible' => true,
                'body_html' => <<<'HTML'
<h2>Overview of the Endoscopy Department</h2>
<p>The Endoscopy Department is a specialized hospital unit where doctors use a thin camera tube to look inside the body for diagnostic exams, therapeutic procedures, and disease screenings. This unit helps doctors find health problems, treat issues without major surgery, and check for early signs of disease.</p>
<p>The Endoscopy Department offers the following:</p>
<ul>
<li>Looking inside the stomach, intestines, or lungs</li>
<li>Taking tiny tissue samples (biopsies)</li>
<li>Stopping internal bleeding</li>
<li>Removing small growths, like polyps</li>
<li>Opening blocked pathways in the body</li>
</ul>
<p><strong>Role of the department:</strong></p>
<ul>
<li>Finding hidden illnesses early</li>
<li>Treating patients without major cuts</li>
<li>Working with other departments, including surgery and cancer teams</li>
<li>Helping patients go home faster after care</li>
</ul>

<h2>Conditions managed</h2>
<p>We manage and diagnose digestive and respiratory disorders, focusing on gastrointestinal bleeding, peptic ulcer disease, and gastroesophageal reflux disease (GERD).</p>

<h3>Upper gastrointestinal conditions</h3>
<ul>
<li><strong>Acid reflux and GERD:</strong> Evaluates severe tissue damage, inflammation, or Barrett's esophagus caused by chronic stomach acid.</li>
<li><strong>Ulcers and gastritis:</strong> Identifies bleeding or painful sores in the stomach and small intestine, often taking targeted tissue biopsies.</li>
<li><strong>Swallowing disorders:</strong> Treats narrowed food pipes or esophageal strictures using dilation tools.</li>
</ul>

<h3>Lower gastrointestinal and biliary conditions</h3>
<ul>
<li><strong>Inflammatory bowel disease:</strong> Monitors and manages complications from Crohn's disease and ulcerative colitis.</li>
<li><strong>Colonic growths:</strong> Detects and removes precancerous polyps or early signs of colorectal tumors.</li>
<li><strong>Gallstone and pancreatic disorders:</strong> Uses specialized scopes (ERCP) to clear blocked bile ducts, treat gallstones, and drain fluid collections.</li>
</ul>

<h2>Signs and symptoms</h2>
<p>You should seek endoscopy care for major warning signs such as trouble swallowing, unexplained weight loss, and bleeding. This includes:</p>
<ul>
<li>Trouble swallowing food</li>
<li>Pain when you swallow</li>
<li>Throwing up blood</li>
<li>Food stuck in your throat</li>
<li>Losing weight without trying</li>
<li>Throwing up a lot</li>
<li>Pain in your upper belly</li>
<li>Feeling full too fast</li>
<li>Black or dark stool</li>
<li>Bright red blood in the stool</li>
<li>Feeling very weak or tired</li>
</ul>

<h2>Diagnostic services</h2>
<p>Diagnostic endoscopy uses thin, flexible, lighted tubes with cameras to examine internal organs, focusing on procedures such as upper endoscopy (EGD), colonoscopy, and bronchoscopy. These tests help doctors find the causes of pain, bleeding, and other internal issues.</p>
<p>Common diagnostic procedures include:</p>
<ul>
<li><strong>Upper endoscopy (EGD):</strong> Checks the esophagus, stomach, and upper small intestine for ulcers, reflux, or persistent pain.</li>
<li><strong>Colonoscopy:</strong> Examines the large intestine and rectum to find polyps, bleeding, or inflammation.</li>
<li><strong>Bronchoscopy:</strong> Views the trachea and lung airways to check for breathing issues or infections.</li>
<li><strong>Endoscopic ultrasound (EUS):</strong> Combines scopes with sound waves to image deep tissues such as the pancreas.</li>
</ul>

<h2>Treatment and procedures</h2>
<p>Our Endoscopy Department provides specialized tests and treatments using thin, flexible tubes with cameras, including upper gastrointestinal endoscopy, colonoscopy, and endoscopic retrograde cholangiopancreatography (ERCP).</p>

<h3>Diagnostic procedures</h3>
<ul>
<li><strong>Upper endoscopy (gastroscopy/EGD):</strong> Inspects the esophagus, stomach, and upper small intestine to find causes of pain, bleeding, or reflux.</li>
<li><strong>Colonoscopy:</strong> Examines the large intestine and rectum for polyps, inflammation, or signs of cancer.</li>
<li><strong>Flexible sigmoidoscopy:</strong> Views the lower part of the large intestine.</li>
<li><strong>Endoscopic ultrasound (EUS):</strong> Uses sound waves with a scope to image deep layers of the digestive tract and nearby organs.</li>
<li><strong>ERCP:</strong> Combines scope and X-ray tools to examine the bile ducts, gallbladder, and pancreas.</li>
</ul>

<h3>Therapeutic and treatment procedures</h3>
<ul>
<li><strong>Biopsy:</strong> Taking small tissue samples for laboratory testing.</li>
<li><strong>Polypectomy:</strong> Removing growths or polyps from the colon or stomach lining.</li>
<li><strong>Bleeding control:</strong> Stopping bleeding from ulcers or vessels using heat probes, clips, or medications.</li>
<li><strong>Stricture dilation:</strong> Stretching narrowed areas of the esophagus or digestive tract using balloons or dilators.</li>
<li><strong>Stent placement:</strong> Placing small metal or plastic tubes to keep blocked ducts or passages open, including cases of difficulty swallowing due to a tumor in the esophagus.</li>
<li><strong>Foreign body removal:</strong> Safely removing swallowed objects or food blockages.</li>
<li><strong>PEG tube placement:</strong> Feeding tubes placed into the stomach.</li>
</ul>

<h2>Patient journey</h2>
<p>The patient journey in the Endoscopy Department includes pre-procedure preparation, the exam itself, and recovery. It ensures safety, comfort, and clear communication from arrival to discharge.</p>

<h3>Before the procedure</h3>
<ul>
<li><strong>Arrival and check-in:</strong> You register at reception, and staff confirm your personal details and medical history.</li>
<li><strong>Initial assessment:</strong> A nurse takes your vital signs (blood pressure, pulse, and temperature) and reviews your allergies and medications.</li>
<li><strong>Changing and prep:</strong> You change into a hospital gown. If you choose sedation, a nurse places a small intravenous (IV) line in your arm.</li>
<li><strong>Consent:</strong> The doctor or nurse explains the test, answers your questions, and asks you to sign a consent form.</li>
</ul>

<h3>During the procedure</h3>
<ul>
<li><strong>Safety checks:</strong> The team confirms your identity and runs through a final safety checklist in the procedure room.</li>
<li><strong>Positioning and comfort:</strong> You lie on a comfortable table, usually on your side. Monitors track your heart rate and oxygen levels.</li>
<li><strong>The test:</strong> The doctor gently inserts the endoscope to view the area or take small tissue samples (biopsies), which takes about 15 to 45 minutes.</li>
</ul>

<h3>After the procedure</h3>
<ul>
<li><strong>Recovery:</strong> Staff move you to a recovery area to rest and monitor your vital signs for at least 30 minutes.</li>
<li><strong>Results and discharge:</strong> The doctor reviews the preliminary results with you, gives you a written report, and explains post-care instructions.</li>
<li><strong>Going home:</strong> If you received sedation, a responsible adult must drive you home and stay with you for 24 hours.</li>
</ul>

<h2>Referral information</h2>
<p>Patients may be referred to the Endoscopy Department for issues such as:</p>
<ul>
<li>Trouble swallowing food</li>
<li>Pain in the chest or throat</li>
<li>Throwing up blood</li>
<li>Severe stomach pain</li>
<li>Sudden weight loss</li>
<li>Blood in your stool</li>
<li>Black or dark stool</li>
<li>Long-term diarrhea</li>
</ul>

<h2>Specialized services and unique expertise</h2>
<p>Our Endoscopy Department stands out through advanced diagnostic imaging, complex therapeutic interventions, and specialized sub-specialty procedures delivered by well-trained and experienced personnel. We are a referral centre across the region and known for decades of esophageal cancer research and treatment. We find disease early, treat deep problems without open cuts, and care for unique patients safely.</p>

<h3>Advanced diagnostics</h3>
<ul>
<li>High-definition and zoom scopes for clear views</li>
<li>Narrow Band Imaging (NBI) to spot early cancer</li>
<li>Endoscopic Ultrasound (EUS) to see deep tissues</li>
<li>Chromoendoscopy</li>
</ul>

<h3>Therapeutic interventions</h3>
<ul>
<li>Endoscopic Submucosal Dissection (ESD) to remove large tumors</li>
<li>ERCP to clear blocked bile ducts</li>
<li>Endoscopic Mucosal Resection (EMR) to remove flat polyps</li>
<li>Rapid treatments to stop internal bleeding</li>
</ul>

<h3>Specialized sub-specialties</h3>
<ul>
<li>Pediatric care for infants and small children</li>
<li>Third-space procedures such as POEM for swallowing disorders</li>
<li>Advanced bariatric and weight-loss support tools</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is an endoscopy?</h3>
<p>A test using a thin, flexible tube with a light and camera to look inside your body.</p>
<h3>How long does it take?</h3>
<p>Upper endoscopies take about 15 minutes, while lower procedures such as a colonoscopy take 30 to 45 minutes.</p>
<h3>Is it painful?</h3>
<p>No. You are given a numbing spray for your throat or medicine to sleep through the procedure.</p>
<h3>How do I get ready?</h3>
<p>Stop eating and drinking (even water) for 6 hours before the test, unless your care team gives different instructions.</p>
<h3>Can I drive home?</h3>
<p>No. If you receive sedation, an adult must take you home.</p>
<h3>When can I eat?</h3>
<p>You can usually eat a light meal once you leave the recovery area.</p>

<h2>Contact and location</h2>
<p>Talk to us today through the Endoscopy contact line: <a href="tel:+254717971768">0717 971 768</a>.</p>
<p>You can also <a href="/book-appointment">book a consultation</a> with one of our doctors for further questions.</p>
<p>We are located on the <strong>1st Floor</strong> at the AGC Tenwek Cardiothoracic Centre.</p>
HTML,
            ],
        ];
    }
}
