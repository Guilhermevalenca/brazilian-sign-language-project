<?php

namespace App\Http\Controllers;

use App\Http\Requests\example\StoreExampleRequest;
use App\Http\Requests\example\UpdateExampleRequest;
use App\Models\Example;

class ExampleController extends Controller
{

    public function store(StoreExampleRequest $request)
    {
        $validated = $request->validated();

        $example = Example::create($validated);

        return response($example, 201);
    }

    public function show(Example $example)
    {
        return response($example, 200);
    }

    public function update(UpdateExampleRequest $request, Example $example)
    {
        $validated = $request->validated();

        $example->update($validated);

        return response($example, 200);
    }

    public function destroy(Example $example)
    {
        $example->delete();

        return response(null, 204);
    }
}
