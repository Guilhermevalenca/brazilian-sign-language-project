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
        $subject = Subject::/*orderBy('name')->*/ paginate();
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
        if (isset($validated['keywords'])) {
            $subject->keywords()->attach($validated['keywords']);
        }
        return response($subject, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->setRelation('signs', $subject->signs()->paginate());
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
            $subject->courses()->sync($validated['courses']);
        }
        if (isset($validated['keywords'])) {
            $subject->keywords()->sync($validated['keywords']);
        }
        return response($subject, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $relations = ['courses', 'keywords', 'signs'];
        foreach ($relations as $relation) {
            $subject->$relation()->sync([]);
        }
        $subject->delete();
        return response(null, 204);
    }
}
