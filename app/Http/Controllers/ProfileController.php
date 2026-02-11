<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function clearDatabase(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password !== 'Godworksinmysteriousways.youareclearingthedatabase') {
            return back()->with('error', 'Incorrect password. Database clear aborted.');
        }

        try {
            DB::statement('PRAGMA foreign_keys = OFF;');
            
            DB::table('sale_items')->truncate();
            DB::table('sales')->truncate();
            DB::table('products')->truncate();
            DB::table('categories')->truncate();
            
            DB::statement('PRAGMA foreign_keys = ON;');

            return back()->with('success', 'System data cleared successfully. Users table was preserved.');
        } catch (\Exception $e) {
            DB::statement('PRAGMA foreign_keys = ON;');
            return back()->with('error', 'An error occurred while clearing the database: ' . $e->getMessage());
        }
    }
}
