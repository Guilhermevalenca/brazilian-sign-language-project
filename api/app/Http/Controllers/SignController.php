<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignRequest;
use App\Models\Sign;

class SignController extends Controller
{
    public function index()
    {
        return response(Sign::paginate(), 200);
    }

    public function store(SignRequest $request)
    {
        $validated = $request->validated();

        $sign = Sign::create($validated);

        if(isset($validated['description'])) {
            $sign->description()->create($validated['description']);
        }

        if(isset($validated['example'])) {
            $sign->example()->create($validated['example']);
        }

        return response($sign, 201);
    }

    public function show(Sign $sign)
    {
        $sign->load('description', 'example');

        return response($sign, 200);
    }

    public function update(SignRequest $request, Sign $sign)
    {
        $validated = $request->validated();

        $sign->update($validated);

        if(isset($validated['description'])) {
            $sign->description()->update($validated['description']);
        }

        if(isset($validated['example'])) {
            $sign->example()->update($validated['example']);
        }

        return response($sign, 200);
    }

    public function destroy(Sign $sign)
    {
        $sign->delete();

        return response(null, 204);
    }
}
