<?php

namespace App\Http\Controllers;

use App\Http\Requests\profile\DestroyProfileRequest;
use App\Http\Requests\profile\UpdatePasswordProfileRequest;
use App\Http\Requests\profile\UpdateProfileRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $request->validated();

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response($user, 200);
    }

    public function updatePassword(UpdatePasswordProfileRequest $request)
    {
        $request->validated();

        if(!Hash::check($request->password, $request->user()->password)) {
            return response(['message' => 'Senha incorreta.'], 403);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response($request->user(), 200);
    }

    public function destroy(DestroyProfileRequest $request)
    {
        $request->validated();

        if (!Hash::check($request->password, $request->user()->password)) {
            return response(['message' => 'Senha incorreta.'], 403);
        }

        $request->user()->delete();
        return response(null, 204);
    }
}
