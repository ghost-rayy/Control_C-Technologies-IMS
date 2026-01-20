<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'staff';
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff account created successfully.');
    }

    public function edit(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff account updated successfully.');
    }

    public function toggleActive(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $staff->update([
            'is_active' => !$staff->is_active,
        ]);

        $status = $staff->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff account {$status} successfully.");
    }

    public function destroy(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff account deleted successfully.');
    }
}
