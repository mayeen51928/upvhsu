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
    }
}
