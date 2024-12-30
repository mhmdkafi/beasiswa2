<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\PendaftarBeasiswa;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $notificationCount = PendaftarBeasiswa::where('user_id', auth()->user()->id)
            ->where('status', '!=', 'pending')
            ->where('is_read', 0)
            ->count();
        return view('users.profile.index', compact('notificationCount'));
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (auth()->user()->image && file_exists(public_path('img/profile/' . auth()->user()->image))) {
            unlink(public_path('img/profile/' . auth()->user()->image));
        }
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('img/profile'), $imageName);

        auth()->user()->update(['image' => $imageName]);

        return back()->with('success', 'Profile picture updated successfully');

    }

    public function updatePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|confirmed|max:255'
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        auth()->user()->update($validated);

        return redirect()->back()->with('success', 'Personal information updated successfully');
    }


    public function updateIPK(Request $request)
    {
        $request->validate([
            'ipk' => 'required|numeric|min:0|max:4',
            'toefl' => 'required|numeric',
        ]);


        auth()->user()->update($request->all());

        return back()->with('success', 'IPK information updated successfully');
    }
}
