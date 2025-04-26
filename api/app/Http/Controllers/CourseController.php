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
        $courses = Course::orderBy('name')->paginate();
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

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');

                // Se for string JSON, decodifica
                if (is_string($keywords)) {
                    $validated['keywords'] = json_decode($keywords, true);
                }
                // Se já for array, usa diretamente
                elseif (is_array($keywords)) {
                    $validated['keywords'] = $keywords;
                }
            }

            $course = Course::create($validated);

            if (!empty($validated['subjects'])) {
                $course->subjects()->attach($validated['subjects']);
            }
            if (!empty($validated['keywords'])) {
                $course->keywords()->attach($validated['keywords']);
            }

            return response()->json($course, 201);

        } catch (\Exception $e) {
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'message' => 'Erro ao criar curso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->subjects = $course->subjects()
            ->orderBy('name')
            ->paginate();
        return response($course, 200);
    }

    public function edit(Course $course) {
        $course->load([
            'keywords',
        ]);
        return response($course, 200);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        try {
            if ($request->hasFile('image')) {
                //remove a imagem antiga
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }
                //salva a imagem e cria um path da nova imagem para posteriormente salvar no banco
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

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');

                // Se for string JSON, decodifica
                if (is_string($keywords)) {
                    $validated['keywords'] = json_decode($keywords, true);
                }
                // Se já for array, usa diretamente
                elseif (is_array($keywords)) {
                    $validated['keywords'] = $keywords;
                }
            }
            if (!empty($validated['subjects'])) {
                $course->subjects()->sync($validated['subjects']);
            }
            if (!empty($validated['keywords'])) {
                $course->keywords()->sync($validated['keywords']);
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
        $course->delete();
        return (response(null, 204));
    }
}
