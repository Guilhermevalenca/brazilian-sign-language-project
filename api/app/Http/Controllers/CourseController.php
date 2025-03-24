<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
        try {
            $validated = $request->validated();

            $path = $request->file('image')->store('courses', 'public');
            $validated['image'] = $path;

            if ($request->has('subjects')) {
                $subjects = $request->input('subjects');

                // Se for string JSON, decodifica
                if (is_string($subjects)) {
                    $validated['subjects'] = json_decode($subjects, true);
                }
                // Se já for array, usa diretamente
                elseif (is_array($subjects)) {
                    $validated['subjects'] = $subjects;
                }
            }

            $course = Course::create($validated);

            if (!empty($validated['subjects'])) {
                $course->subjects()->attach($validated['subjects']);
            }

            return response()->json($course, 201);

        } catch (\Exception $e) {
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'message' => 'Erro ao criar curso',
                'error' => $e->getMessage(),
                'received_data' => $request->all() // Para debug
            ], 500);
        }
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

        try {
            if ($request->hasFile('image')) {
                // Remove a imagem antiga se existir
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }
                // Armazena a nova imagem
                $path = $request->file('image')->store('courses', 'public');
                $validated['image'] = $path;
            }
            if ($request->has('subjects')) {
                $subjects = $request->input('subjects');

                // Se for string JSON, decodifica
                if (is_string($subjects)) {
                    $validated['subjects'] = json_decode($subjects, true);
                }
                // Se já for array, usa diretamente
                elseif (is_array($subjects)) {
                    $validated['subjects'] = $subjects;
                }
            }
            if (!empty($validated['subjects'])) {
                $course->subjects()->sync($validated['subjects']);
            }

            $course->update($validated);
            return response($course, 200);
        } catch (\Exception $e) {
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }
            return response($e->getMessage(), 500);
        }
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
