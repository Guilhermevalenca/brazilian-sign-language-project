<?php

namespace App\Http\Controllers;

use App\Http\Requests\description\StoreDescriptionRequest;
use App\Http\Requests\description\UpdateDescriptionRequest;
use App\Models\Description;

class DescriptionController extends Controller
{
    public function store(StoreDescriptionRequest $request)
    {
        $validated = $request->validated();

        $description = Description::create($validated);

        return response($description, 201);
    }

    public function show(Description $description)
    {
        return response($description, 200);
    }

    public function update(UpdateDescriptionRequest $request, Description $description)
    {
        $validated = $request->validated();

        $description->update($validated);

        return response($description, 200);
    }
    public function destroy(Description $description)
    {
        $description->delete();

        return response(null, 204);
    }
}
