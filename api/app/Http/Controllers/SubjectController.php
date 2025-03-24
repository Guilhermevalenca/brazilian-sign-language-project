<?php

namespace App\Http\Controllers;

use App\Http\Requests\subject\StoreSubjectRequest;
use App\Http\Requests\subject\UpdateSubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subject = Subject::paginate();
        return response($subject, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();
        $subject = Subject::create($validated);
        if (isset($validated['courses'])) {
            $subject->courses()->attach($validated['courses']);
        }
        return response($subject, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('courses');
        return response($subject, 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validated = $request->validated();
        $subject->update($validated);
        if (isset($validated['courses'])) {
            $subject->courses()->attach($validated['courses']);
        }
        return response($subject, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->courses()->detach();
        $subject->delete();
        return response(null, 204);
    }
}
