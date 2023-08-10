<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->freelancer;
        return view('freelancer.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'between: 3, 50'],
            'last_name' => ['required', 'string', 'between: 3, 50'],
        ]);

        $user = Auth::user();
        $user->freelancer()->updateOrCreate([
            'user_id' => $user->id,
        ], $request->all());

        return redirect()
            ->route('freelancer.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
