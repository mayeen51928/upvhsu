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
