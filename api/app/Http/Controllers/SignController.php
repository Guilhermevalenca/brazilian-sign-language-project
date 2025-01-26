<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignRequest;
use App\Http\Requests\UpdateSignRequest;
use App\Models\Sign;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSignRequest $request)
    {
        $validated = $request->validated();

        $sign = Sign::create($validated);

        if(array_key_exists('moveset', $validated)){
            $sign->moveset()->create($validated['moveset']);
        }

        if(array_key_exists('examples', $validated)){
            $sign->examples()->createMany($validated['examples']);
        }

        if(array_key_exists('description', $validated)){
            $sign->description()->create($validated['description']);
        }

        return response(null, 204);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sign $sign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sign $sign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSignRequest $request, Sign $sign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sign $sign)
    {
        //
    }
}
