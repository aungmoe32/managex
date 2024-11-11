<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Factories\SubjectFactory;
use Database\Factories\TeacherFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        $users = User::all();
        Teacher::factory(5)->recycle($users)->create();

        $this->call(SemesterSeeder::class);
        $semesters = Semester::all();
        Subject::factory(10)->recycle($semesters)->create();

        $subjects = Subject::all();
        Teacher::all()->each(function ($teacher) use ($subjects) {
            $teacher->subjects()->attach(
                // $subjects->random(rand(1, 3))->pluck('id')->toArray()
                $subjects->random(1)->pluck('id')->toArray()
            );
        });
    }
}
