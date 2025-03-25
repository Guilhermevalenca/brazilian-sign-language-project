<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithFiltersKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string'],
        ]);
        $keywords = Keyword::select('id')->where('name', 'like', '%' . $request->search . '%')
            ->with(['courses', 'subjects', 'signs'])
            ->first();
        return response($keywords, 200);
    }

    public function withFilters(WithFiltersKeywordRequest $request) 
    {
        $request->validated();

        $keywords = Keyword::select('id')->where('name', 'like', '%' . $request->search . '%');

        if(!$request->filterOptions['courses'] && !$request->filterOptions['subjects'] && !$request->filterOptions['signs']) {
            $keywords = $keywords->with(['courses', 'subjects', 'signs']);
        } else {
            if($request->filterOptions['courses']) {
                $keywords = $keywords->with('courses');
            }
            if($request->filterOptions['subjects']) {
                $keywords = $keywords->with('subjects');
            }
            if($request->filterOptions['signs']) {
                $keywords = $keywords->with('signs');
            }
        }

        return response($keywords->paginate(), 200);
    }
    public function create()
    {
        return response(Keyword::orderBy('id', 'desc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        Keyword::create([
            'name' => $request->name 
        ]);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        return response($keyword, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keyword $keyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keyword $keyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        //
    }
}
