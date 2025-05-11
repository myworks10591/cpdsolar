<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GroupController extends Controller
{
    // Show the list of groups
    public function rolePermission($role){
        if (!in_array($role, ['manager', 'admin'])) {
            abort(403, 'Access Denied');
        }
   }
    public function index()
    {
        $this->rolePermission(Auth::user()->role);
        $groups = Group::all();
        return view('admin.groups.index', compact('groups'));
    }

    // Show the form to create a new group
    public function create()
    {
        $this->rolePermission(Auth::user()->role);
        return view('admin.groups.create');
    }

    // Store a new group
    public function store(Request $request)
    {
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Group::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.groups.index')->with('success', 'Group created successfully.');
    }

    // Show the form to edit a group
    public function edit($id)
    {
        $this->rolePermission(Auth::user()->role);
        $group = Group::findOrFail($id);
        return view('admin.groups.edit', compact('group'));
    }

    // Update a group
    public function update(Request $request, $id)
    {
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::findOrFail($id);
        $group->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.groups.index')->with('success', 'Group updated successfully.');
    }

    // Delete a group
    public function destroy($id)
    {   
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.groups.index')->with('success', 'Group deleted successfully.');
    }
}

?>