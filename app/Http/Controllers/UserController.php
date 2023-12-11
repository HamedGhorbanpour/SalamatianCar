<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->has('perPage') ? $request->perPage : 15;
        $users = User::with('brand')->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        })->paginate($perPage);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $users = User::create($request->all());
        return response()->json([
            'message' => 'User Created Successfully' ,
            'data' => $users
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);
        return response()->json([
            'user' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $users = User::findOrFail($id);
        $users->save();
        return response()->json([
            'message' => 'User With ID:'.$id.' Updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json([
            'message' => 'User With ID:'.$id.' Deleted Successfully'
        ]);
    }
}
