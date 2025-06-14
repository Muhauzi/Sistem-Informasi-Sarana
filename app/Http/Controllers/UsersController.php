<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_Divisions;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    protected $divisionModel;

    public function __construct()
    {
        $this->divisionModel = new M_Divisions();
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = $this->divisionModel->all();
        return view('users.create', compact('divisions'));
    }
    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pengelola,pegawai', 
            'division_id' => 'required|exists:divisions,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('division')->findOrFail($id);
        return view('users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $divisions = $this->divisionModel->all();
        return view('users.edit', compact('user', 'divisions'));
    }
    /**
     * Update the specified user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pengelola,pegawai',
            'division_id' => 'required|exists:m_divisions,id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->division_id = $request->division_id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->id === Auth::id()) {
                return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
    /**
     * Get the division associated with the user.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getDivision($id)
    {
        $user = User::findOrFail($id);
        $division = $user->division;

        if (!$division) {
            return response()->json(['message' => 'Division not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($division, Response::HTTP_OK);
    }
    /**
     * Get all users with their divisions.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsersWithDivisions()
    {
        $users = User::with('division')->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($users, Response::HTTP_OK);
    }
}
