<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignRequest;
use App\Models\Sign;
use Exception;

class SignController extends Controller
{
    public function index()
    {
        $signs = Sign::orderBy('name')->paginate();
        return response($signs, 200);
    }

    public function store(SignRequest $request)
    {
        $validated = $request->validated();

        if (!$this->validUrl($validated['display'])) {
            return response([
                'error' => 'O link precisa ser do youtube',
                'origin' => 'sign',
            ], 400);
        }
        $validated['display'] = $this->getVideoId($validated['display']);

        $sign = Sign::create($validated);

        $sign->keywords()->attach($validated['keywords']);
        $sign->subjects()->attach($validated['subjects']);

        if (isset($validated['description'])) {
            if (!$this->validUrl($validated['description']['display'])) {
                return response([
                    'error' => 'O link precisa ser do youtube',
                    'origin' => 'description',
                ], 400);
            }
            $validated['description']['display'] = $this->getVideoId($validated['description']['display']);
            $sign->description()->create($validated['description']);
        }

        if (isset($validated['example'])) {
            if (!$this->validUrl($validated['example']['display'])) {
                return response([
                    'error' => 'O link precisa ser do youtube',
                    'origin' => 'example',
                ], 400);
            }
            $validated['example']['display'] = $this->getVideoId($validated['example']['display']);
            $sign->example()->create($validated['example']);
        }

        return response($sign, 201);
    }

    public function show(Sign $sign)
    {
        $sign->load([
            'description',
            'example',
        ]);
        return response($sign, 200);
    }

    public function edit(Sign $sign)
    {
        $sign->load([
            'description',
            'example',
            'keywords',
            'subjects',
        ]);

        return response($sign, 200);
    }

    public function update(SignRequest $request, Sign $sign)
    {
        $validated = $request->validated();

        if (!$this->validUrl($validated['display'])) {
            return response([
                'error' => 'O link precisa ser do youtube',
                'origin' => 'sign',
            ], 400);
        }
        $validated['display'] = $this->getVideoId($validated['display']);

        $sign->update($validated);
        $sign->keywords()->sync($validated['keywords']);
        $sign->subjects()->sync($validated['subjects']);

        if (isset($validated['description'])) {
            if (!$this->validUrl($validated['description']['display'])) {
                return response([
                    'error' => 'O link precisa ser do youtube',
                    'origin' => 'description',
                ], 400);
            }
            $validated['description']['display'] = $this->getVideoId($validated['description']['display']);

            if ($sign->description) {
                $sign->description()->update($validated['description']);
            } else {
                $sign->description()->create($validated['description']);
            }
        }

        if (isset($validated['example'])) {
            if (!$this->validUrl($validated['example']['display'])) {
                return response([
                    'error' => 'O link precisa ser do youtube',
                    'origin' => 'example',
                ], 400);
            }
            $validated['example']['display'] = $this->getVideoId($validated['example']['display']);

            if ($sign->example) {
                $sign->example()->update($validated['example']);
            } else {
                $sign->example()->create($validated['example']);
            }
        }

        return response($sign, 200);
    }

    public function destroy(Sign $sign)
    {
        $sign->delete();

        return response(null, 204);
    }

    private function validUrl($url)
    {
        return strpos($url, 'https://www.youtube.com') === 0 || strpos($url, 'https://youtu.be') === 0;
    }

    private function getVideoId($display)
    {
        if (strpos($display, "watch?v=") !== false) {
            preg_match('/watch\?v=([^&\s]+)/', $display, $matches);
            if (!empty($matches[1])) {
                $display = $matches[1];
            }
        } else {
            preg_match('/\/([^\/\?]+)\?/', $display, $matches);
            if (!empty($matches[1])) {
                $display = $matches[1];
            }
        }

        return 'https://www.youtube.com/embed/' . $display;
    }
}
