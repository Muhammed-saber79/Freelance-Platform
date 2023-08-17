<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        $birthday = $user->freelancer->birthday->format('d-M/Y');
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
            'email' => ['email'],
        ]);

        $user = Auth::user();
        $old_image = $user->freelancer->profile_image_path;

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            if ($file->isValid()) {
                $path = $file->store('profile_photos', [
                    'disk' => 'public',
                ]);

                $request->merge([
                    'profile_image_path' => $path
                ]);
            }
        }

        // dd($request);

        if ($old_image && $request->profile_image_path) {
            Storage::disk('public')->delete($old_image);
        }

        $user->freelancer()->updateOrCreate([
            'user_id' => $user->id,
        ], $request->all());

        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('freelancer.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
