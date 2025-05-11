<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Group;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $users = User::with('group')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $roles = ['admin', 'operator', 'manager', 'group'];
        $groups = Group::all();
        return view('admin.users.create', compact('roles', 'groups'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,operator,manager,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'group_id' => $request->group_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User Created Successfully');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $roles = ['admin', 'operator', 'manager', 'group'];
        $user = User::findOrFail($id);
        $groups = Group::all();
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,operator,manager,group',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User Deleted Successfully');
    }
}


?>