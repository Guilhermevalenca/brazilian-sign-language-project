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

            if ($request->hasFile('image')) {
                $validated['image'] = $this->convertImageToString($request->file('image'));
            }

            if ($request->has('subjects')) {
                $subjects = $request->input('subjects');

                // Se for string JSON, decodifica
                if (is_string($subjects)) {
                    $validated['subjects'] = json_decode($subjects, true);
                } // Se já for array, usa diretamente
                elseif (is_array($subjects)) {
                    $validated['subjects'] = $subjects;
                }
            }

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');

                // Se for string JSON, decodifica
                if (is_string($keywords)) {
                    $validated['keywords'] = json_decode($keywords, true);
                } // Se já for array, usa diretamente
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

    public function edit(Course $course)
    {
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

                $validated['image'] = $this->convertImageToString($request->file('image'));
            }
            if ($request->has('subjects')) {
                $subjects = $request->input('subjects');

                // Se for string JSON, decodifica
                if (is_string($subjects)) {
                    $validated['subjects'] = json_decode($subjects, true);
                } // Se já for array, usa diretamente
                elseif (is_array($subjects)) {
                    $validated['subjects'] = $subjects;
                }
            }

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');

                // Se for string JSON, decodifica
                if (is_string($keywords)) {
                    $validated['keywords'] = json_decode($keywords, true);
                } // Se já for array, usa diretamente
                elseif (is_array($keywords)) {
                    $validated['keywords'] = $keywords;
                }
            }

            $course->update($validated);

            if (!empty($validated['subjects'])) {
                $course->subjects()->sync($validated['subjects']);
            }
            if (!empty($validated['keywords'])) {
                $course->keywords()->sync($validated['keywords']);
            }

            return response($course, 200);
        } catch (\Exception $e) {
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

    private function convertImageToString($image)
    {
        $binary = file_get_contents($image->getRealPath());

        $json = [
            'base64' => base64_encode($binary),
            'mimeType' => $image->getMimeType(),
        ];

        return 'data: '. $json['mimeType'] . ';base64,' . $json['base64'];
    }
}
