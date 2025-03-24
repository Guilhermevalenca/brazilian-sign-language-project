<?php

namespace App\Http\Controllers;

use App\Http\Requests\course\StoreCourseRequest;
use App\Http\Requests\course\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate();
        return response($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();
        $course = Course::create($validated);
        if (isset($validated['subjects'])) {
            $course->subjects()->attach($validated['subjects']);
        }
        return response($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('subjects');
        return response($course, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();
        $course->update($validated);
        return response($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->subjects()->detach();
        $course->delete();
        return (response(null, 204));
    }
}
