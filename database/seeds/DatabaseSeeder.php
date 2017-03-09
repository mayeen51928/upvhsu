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

    }
}
