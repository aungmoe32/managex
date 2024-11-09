<?php

namespace Database\Seeders;

use App\Constants\Major;
use App\Constants\Term;
use App\Constants\Year;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Major::getAllMajors() as $major) {
            foreach (Year::getAllYears() as $year) {
                foreach (Term::getAllTerms() as $term) {
                    Semester::create([
                        'major' => $major,
                        'year' => $year,
                        'term' => $term,
                    ]);
                }
            }
        }
    }
}
