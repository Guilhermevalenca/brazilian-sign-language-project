<?php

namespace App\Http\Controllers;

use App\Http\Requests\subject\StoreSubjectRequest;
use App\Http\Requests\subject\UpdateSubjectRequest;
use App\Models\Subject;
use App\Models\Sign;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subject = Subject::orderBy('name')->paginate();
        return response($subject, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();
        $subject = Subject::create($validated);
        if (isset($validated['courses'])) {
            $subject->courses()->attach($validated['courses']);
        }
        if (isset($validated['keywords'])) {
            $subject->keywords()->attach($validated['keywords']);
        }
        return response($subject, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->signs = $subject->signs()
            ->select('signs.*') // garante que pegamos apenas os campos da tabela signs
            ->joinSub(function ($query) {
                $query->select('s.id',
                    DB::raw("string_agg(
                            CASE
                                WHEN tok ~ '^\d+$'
                                    THEN to_char(tok::bigint, 'FM00000000000000000000')
                                ELSE lower(tok)
                            END,
                            '' ORDER BY ord
                        ) AS nat_key")
                )
                    ->from('signs as s')
                    ->join(DB::raw("LATERAL (
                    SELECT (regexp_matches(s.name, '\\d+|\\D+', 'g'))[1] AS tok, ordinality AS ord
                    FROM regexp_matches(s.name, '\\d+|\\D+', 'g') WITH ORDINALITY
                ) AS t"), function ($join) {
                        $join->on('s.id', '=', 's.id'); // join lateral “dummy”, só pra SQL aceitar
                    })
                    ->groupBy('s.id');
            }, 'k', 'k.id', '=', 'signs.id')
            ->orderBy('k.nat_key')
            ->orderBy('signs.name')
            ->paginate(8);
        return response($subject, 200);
    }

    public function edit(Subject $subject) {
        $subject->load([
            'courses',
            'keywords'
        ]);
        return response($subject, 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validated = $request->validated();
        $subject->update($validated);
        if (isset($validated['courses'])) {
            $subject->courses()->sync($validated['courses']);
        }
        if (isset($validated['keywords'])) {
            $subject->keywords()->sync($validated['keywords']);
        }
        return response($subject, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response(null, 204);
    }
}
