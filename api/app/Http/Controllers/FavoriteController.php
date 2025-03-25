<?php

namespace App\Http\Controllers;

use App\Http\Requests\favorite\UpdateFavoriteRequest;
use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->paginate();

        return response($favorites, 200);
    }

   public function store(FavoriteRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->favorites()->create($validated);

        return response(null, 204);
    }

    public function destroy(FavoriteRequest $request)
    {
        $request->validated();

        auth()->user()->favorites()
            ->where('sign_id', $request->sign_id)
            ->delete();

        return response(null, 204);
    }
}
