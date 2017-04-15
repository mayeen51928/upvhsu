<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('user_types')->insert([
			'user_type_description' => 'Patient',
			]);

		DB::table('user_types')->insert([
			'user_type_description' => 'Staff',
			]);

		DB::table('user_types')->insert([
			'user_type_description' => 'Admin',
			]);

		DB::table('patient_types')->insert([
			'patient_type_description' => 'Student',
			]);

		DB::table('patient_types')->insert([
			'patient_type_description' => 'Faculty',
			]);

		DB::table('patient_types')->insert([
			'patient_type_description' => 'Staff',
			]);

		DB::table('patient_types')->insert([
			'patient_type_description' => 'Dependent',
			]);

		DB::table('patient_types')->insert([
			'patient_type_description' => 'OPD',
			]);
	
		DB::table('staff_types')->insert([
			'staff_type_description' => 'Dentist',
			]);

		DB::table('staff_types')->insert([
			'staff_type_description' => 'Doctor',
			]);

		DB::table('staff_types')->insert([
			'staff_type_description' => 'Lab',
			]);

		DB::table('staff_types')->insert([
			'staff_type_description' => 'X-ray',
			]);

		DB::table('staff_types')->insert([
			'staff_type_description' => 'Cashier',
			]);

		// $this->call(UsersTableSeeder::class);
		DB::table('users')->insert([
			'user_id' => 'admin',
			'password' =>bcrypt('123456'),
			'user_type_id' => 3,
			]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Community Development',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA History',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Literature',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Political Science',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Psychology',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Sociology',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BA Communication and Media Studies',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Applied Mathematics',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Biology',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Chemistry',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Computer Science',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Economics',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Public Health',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Statistics',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Chemistry',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Biology)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (English as a Second Language)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Filipino)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Guidance)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Mathematics)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Physics)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Reading)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Education (Social Studies)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'MS Biology',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Fisheries',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Aquaculture',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Marine Affairs',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'MS Fisheries (Aquaculture)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'MS Fisheries (Fisheries Biology)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'MS Fisheries (Fish Processing Technology)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'MS Ocean Sciences',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Professional Masters in Tropical Marines',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'PhD Fisheries',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Accountancy',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Business Administration (Marketing)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Management',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Management (Business Management)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Master of Management (Public Management)',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'Diploma in Urban and Regional Planning',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Chemical Engineering',
		]);
		DB::table('degree_programs')->insert([
			'degree_program_description' => 'BS Food Technology',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Caries free',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Caries for filting',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Caries for extraction',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Root fragment',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Missing due to carries',
		]);
		DB::table('dental_conditions')->insert([
			'condition_description' => 'Null',
		]);

		DB::table('dental_operations')->insert([
			'operation_description' => 'Amalgam filling',
		]);
		DB::table('dental_operations')->insert([
			'operation_description' => 'Silicate filling',
		]);
		DB::table('dental_operations')->insert([
			'operation_description' => 'Extraction due to caries',
		]);
		DB::table('dental_operations')->insert([
			'operation_description' => 'Extraction due to other causes',
		]);
		DB::table('dental_operations')->insert([
			'operation_description' => 'Cement filling',
		]);
		DB::table('dental_operations')->insert([
			'operation_description' => 'Null',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Consultation Fee',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '200',
			'senior_rate' => '160',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Emergency Room Fee',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '100',
			'senior_rate' => '100',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'IV Insertion',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Injection Fee',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '10',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Skin Test',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '8',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Oxygen Inhalation Fee',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '40',
			'opd_rate' => '50',
			'senior_rate' => '50',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'BP Taking',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '20',
			'senior_rate' => '16',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Wounddressing (Small)',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '12.5',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Woundressing (Large)',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '25',
			'opd_rate' => '100',
			'senior_rate' => '80',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Suturing (Minor)',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '50',
			'opd_rate' => '200',
			'senior_rate' => '160',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Incision & Drainage',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '50',
			'opd_rate' => '200',
			'senior_rate' => '160',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Inhalation',
			'student_rate' => '10',
			'faculty_staff_dependent_rate' => '20',
			'opd_rate' => '230',
			'senior_rate' => '184',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'ECG',
			'student_rate' => '100',
			'faculty_staff_dependent_rate' => '150',
			'opd_rate' => '230',
			'senior_rate' => '184',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'ECG Reading',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '70',
			'senior_rate' => '56',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Room Rate (Private)',
			'student_rate' => '50',
			'faculty_staff_dependent_rate' => '80',
			'opd_rate' => '130',
			'senior_rate' => '100',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Room Rate (Ward)',
			'student_rate' => '20',
			'faculty_staff_dependent_rate' => '40',
			'opd_rate' => '100',
			'senior_rate' => '60',
			'service_type' => 'medical',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Platelet Count',
			'student_rate' => '30',
			'faculty_staff_dependent_rate' => '40',
			'opd_rate' => '70',
			'senior_rate' => '56',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'CT - BT',
			'student_rate' => '22.5',
			'faculty_staff_dependent_rate' => '30',
			'opd_rate' => '60',
			'senior_rate' => '48',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'HCT',
			'student_rate' => '20',
			'faculty_staff_dependent_rate' => '25',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => "Widal's Test",
			'student_rate' => '75',
			'faculty_staff_dependent_rate' => '200',
			'opd_rate' => '300',
			'senior_rate' => '250',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Pregnancy Test',
			'student_rate' => '90',
			'faculty_staff_dependent_rate' => '120',
			'opd_rate' => '150',
			'senior_rate' => '0',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Blood Typing',
			'student_rate' => '20',
			'faculty_staff_dependent_rate' => '25',
			'opd_rate' => '80',
			'senior_rate' => '64',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'FBS',
			'student_rate' => '40',
			'faculty_staff_dependent_rate' => '50',
			'opd_rate' => '120',
			'senior_rate' => '96',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Cholesterol',
			'student_rate' => '70',
			'faculty_staff_dependent_rate' => '40',
			'opd_rate' => '145',
			'senior_rate' => '116',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Tiglycerides',
			'student_rate' => '100',
			'faculty_staff_dependent_rate' => '125',
			'opd_rate' => '155',
			'senior_rate' => '124',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'CBC',
			'student_rate' => '35',
			'faculty_staff_dependent_rate' => '45',
			'opd_rate' => '100',
			'senior_rate' => '80',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Lipid Profile',
			'student_rate' => '285',
			'faculty_staff_dependent_rate' => '380',
			'opd_rate' => '600',
			'senior_rate' => '480',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'HDL',
			'student_rate' => '65',
			'faculty_staff_dependent_rate' => '85',
			'opd_rate' => '155',
			'senior_rate' => '124',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Uric Acid',
			'student_rate' => '65',
			'faculty_staff_dependent_rate' => '85',
			'opd_rate' => '150',
			'senior_rate' => '120',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Creatinine',
			'student_rate' => '60',
			'faculty_staff_dependent_rate' => '75',
			'opd_rate' => '130',
			'senior_rate' => '104',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Bun',
			'student_rate' => '60',
			'faculty_staff_dependent_rate' => '75',
			'opd_rate' => '120',
			'senior_rate' => '96',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'ECG',
			'student_rate' => '100',
			'faculty_staff_dependent_rate' => '150',
			'opd_rate' => '200',
			'senior_rate' => '150',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Hemoglobin',
			'student_rate' => '15',
			'faculty_staff_dependent_rate' => '20',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Papsmear',
			'student_rate' => '170',
			'faculty_staff_dependent_rate' => '225',
			'opd_rate' => '250',
			'senior_rate' => '200',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'SGPT',
			'student_rate' => '117',
			'faculty_staff_dependent_rate' => '156',
			'opd_rate' => '220',
			'senior_rate' => '176',
			'service_type' => 'cbc',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Drug Test',
			'student_rate' => '20',
			'faculty_staff_dependent_rate' => '30',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'drugtest',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Urinalysis',
			'student_rate' => '22.5',
			'faculty_staff_dependent_rate' => '30',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'urinalysis',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'fecalysis',
			'student_rate' => '15',
			'faculty_staff_dependent_rate' => '20',
			'opd_rate' => '50',
			'senior_rate' => '40',
			'service_type' => 'fecalysis',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Lumbo Sacral/Apl',
			'student_rate' => '285',
			'faculty_staff_dependent_rate' => '380',
			'opd_rate' => '550',
			'senior_rate' => '462',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Skull Apl/View',
			'student_rate' => '240',
			'faculty_staff_dependent_rate' => '320',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Critical/View',
			'student_rate' => '114',
			'faculty_staff_dependent_rate' => '152',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Pelvis',
			'student_rate' => '114',
			'faculty_staff_dependent_rate' => '152',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Hip',
			'student_rate' => '114',
			'faculty_staff_dependent_rate' => '152',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Foot Apl',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Leg',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Knee Apl',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Thigh Apl',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Ankle',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Chest Pa-ap',
			'student_rate' => '105',
			'faculty_staff_dependent_rate' => '140',
			'opd_rate' => '250',
			'senior_rate' => '216',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Chest Lateral',
			'student_rate' => '105',
			'faculty_staff_dependent_rate' => '140',
			'opd_rate' => '250',
			'senior_rate' => '216',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Apico Lordotic',
			'student_rate' => '105',
			'faculty_staff_dependent_rate' => '140',
			'opd_rate' => '250',
			'senior_rate' => '216',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Chest Bucky',
			'student_rate' => '152',
			'faculty_staff_dependent_rate' => '152',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Lateral Dicubitus',
			'student_rate' => '105',
			'faculty_staff_dependent_rate' => '140',
			'opd_rate' => '250',
			'senior_rate' => '210',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Hand',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Wrist',
			'student_rate' => '144',
			'faculty_staff_dependent_rate' => '192',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Forearm Apl',
			'student_rate' => '156',
			'faculty_staff_dependent_rate' => '208',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Elbow Apl',
			'student_rate' => '144',
			'faculty_staff_dependent_rate' => '192',
			'opd_rate' => '370',
			'senior_rate' => '310.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Upper Arm',
			'student_rate' => '144',
			'faculty_staff_dependent_rate' => '192',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Shoulder',
			'student_rate' => '120',
			'faculty_staff_dependent_rate' => '160',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Clavice',
			'student_rate' => '120',
			'faculty_staff_dependent_rate' => '160',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('medical_services')->insert([
			'service_description' => 'Scapula',
			'student_rate' => '120',
			'faculty_staff_dependent_rate' => '160',
			'opd_rate' => '270',
			'senior_rate' => '226.8',
			'service_type' => 'xray',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Consutation',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '200',
			'senior_rate' => '160',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Oral Prophylaxis',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '0',
			'senior_rate' => '0',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Slight to Moderate Calcular Deposits',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '250',
			'senior_rate' => '200',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Heavy Calcular Deposits',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '300',
			'senior_rate' => '240',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Tooth Extraction',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '0',
			'senior_rate' => '0',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Temporary Tooth',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '200',
			'senior_rate' => '160',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Permanent Tooth',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '300',
			'senior_rate' => '240',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Filling',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '0',
			'senior_rate' => '0',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Temporary Filling',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '150',
			'senior_rate' => '120',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Permanent Filling',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '300',
			'senior_rate' => '240',
		]);
		DB::table('dental_services')->insert([
			'service_description' => 'Cementation',
			'student_rate' => '0',
			'faculty_staff_dependent_rate' => '0',
			'opd_rate' => '150',
			'senior_rate' => '120',
		]);

	}
}
