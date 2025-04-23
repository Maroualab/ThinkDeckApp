<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user(); 
        $email = $user->email; 

        return view('profile.show', compact('user', 'email'));
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user(); 
        return view('profile.edit', compact('user')); // Pass the user to the view
    }

    /**
     * Update the user's profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate and update the user's profile
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
                function ($value, $fail) {
                    if (Hash::check($value, auth()->user()->password)) {
                        $fail('The new password cannot be the same as the old password.');
                    }
                },
            ],
        ]);

        // Hash the password if it is provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); 
        }

        $user = auth()->user();
        $user->update($validatedData);

        return response()->redirectToRoute('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the user's profile from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = auth()->user();
        $user->delete();

        auth()->logout();

        return response()->redirectToRoute('welcome')->with('success', 'Your account has been deleted successfully.');
    }
}