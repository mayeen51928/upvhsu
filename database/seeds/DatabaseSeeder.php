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
        DB::table('degree_programs')->insert([
            'degree_program_description' => 'BA Community Development',
        ]);
        DB::table('degree_programs')->insert([
            'degree_program_description' => 'BA History',
        ]);
    }
}
