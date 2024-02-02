<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->has('perPage') ? $request->perPage : 15;
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        })->paginate($perPage);
        return response()->json(new UserCollection($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $users = User::create($request->all());
        return response()->json([
            'message' => 'کاربر جدید اضافه شد' ,
            'data' => $users
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);
        return response()->json($users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $users = User::findOrFail($id);
        $users->fill($request->only([
            'name' , 'email'
        ]));
        $users->save();
        return response()->json([
            'message' => 'اطلاعات کاربر با موفقیت بروزرسانی شد' ,
            'data' => $users
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json([
            'message' => 'کاربر با موفقیت حذف شد' ,
            'data' => $users
        ],200);
    }
}
