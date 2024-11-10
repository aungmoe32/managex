<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Constants\Constant;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\SubjectResource;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = QueryBuilder::for(Teacher::class)
            ->allowedFilters([AllowedFilter::exact('experience'), 'subjects.name', AllowedFilter::exact('subjects.semester.major')])
            ->allowedIncludes(['subjects', 'subjects.semester'])
            ->with('user')
            ->paginate(Constant::PageSize);

        // return SubjectResource::collection($subjects);
        return $teachers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
