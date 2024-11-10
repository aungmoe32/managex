<?php

namespace App\Http\Controllers;

use App\Constants\Constant;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubjectController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subjects = QueryBuilder::for(Subject::class)
            ->allowedFilters(['name', AllowedFilter::exact('code'), AllowedFilter::exact('semester.id')])
            ->allowedIncludes(['semester'])
            ->paginate(Constant::PageSize);

        // return SubjectResource::collection($subjects);
        return $subjects;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        return Subject::create($request->safe()->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = QueryBuilder::for(Subject::class)
            ->allowedIncludes(['semester'])
            ->where('id', $id)->get();
        return $subject;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->safe()->all());
        return $subject;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return $this->ok('Subject successfully deleted');
    }
}
