<?php

namespace App\Http\Controllers;

use App\Http\Requests\sign\StoreSignRequest;
use App\Http\Requests\sign\UpdateSignRequest;
use App\Models\Sign;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Sign::with('moveset')
            ->paginate();
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
        $validation = $request->validated();

        $sign = Sign::create($validation);

        if(isset($validation['examples'])) {
            $sign->examples()->createMany($validation['examples']);
        }

        if(isset($validation['description'])) {
            $sign->description()->create($validation['description']);
        }

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sign $sign)
    {
        $sign->load('moveset', 'examples', 'description');

        return response($sign,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sign $sign)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSignRequest $request, Sign $sign)
    {
        $validation = $request->validated();
        $sign->update($validation);

        if(isset($validation['examples'])) {
            $sign->examples()->update($validation['examples']);
        }
        if(isset($validation['description'])) {
            $sign->description()->update($validation['description']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sign $sign)
    {
        $sign->delete();
        return response(null, 204);
    }

    public function favorite(Sign $sign)
    {
        auth()->user()->favorites()->create([
            'sign_id' => $sign->id
        ]);
        return response(null, 201);
    }
}
