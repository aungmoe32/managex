<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Permissions\Roles;
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
        $this->call(PermissionSeeder::class);
        \App\Models\User::factory(10)->create();

        // $users = User::all();
        // $users->each(function ($user) {
        //     $user->assignRole(Roles::SiwTUDENT);
        // });
    }
}
