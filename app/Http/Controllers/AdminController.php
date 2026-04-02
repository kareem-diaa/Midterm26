<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreLibrarianRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function membersList()
    {
        $members = User::where('role', 'member')->get();
        return view('admin.members', compact('members'));
    }

    public function storeLibrarian(StoreLibrarianRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'librarian',
        ]);

        return redirect()->route('admin.members')->with('status', 'Librarian account created.');
    }

    public function rolesIndex()
    {
        // Simple immutable array maps role to their permissions interface without DB overhead
        $rolesData = [
            'Admin' => 'Create Librarians, View Members, View Roles, full Books Management',
            'Librarian' => 'View Members, full Books Management',
            'Member' => 'View Book Catalogue, Borrow Books, View Own Borrowed Books',
        ];

        return view('admin.roles', compact('rolesData'));
    }
}
