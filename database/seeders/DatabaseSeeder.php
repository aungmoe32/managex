<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Semester;
use App\Models\Subject;
use Database\Factories\SubjectFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@examle.com',
        // ]);

        $this->call(SemesterSeeder::class);
        $semesters = Semester::all();
        Subject::factory(10)->recycle($semesters)->create();
    }
}
