<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Requests\Brand\CreateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->has('perPage') ? $request->perPage : 15;
        $cars = Brand::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");})->paginate($perPage);
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBrandRequest $request)
    {
        $brand = Brand::create($request->all() + ['user_id' => auth()->id()]
        );
        return response()->json([
            'message' => 'برند جدید اضافه شد' ,
            'data' => $brand
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrfail($id);
        return response()->json([
            'data' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = Brand::findOrfail($id);
            $brand->fill($request->only(['name']));
            $brand->save();
            return response()->json([
                'message' => 'اطلاعات برند با موفقیت بروزرسانی شد' ,
                'data' => $brand
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrfail($id);
            $brand->delete();
            return response()->json([
                'message' => 'برند با موفقیت حذف شد' ,
                'data' => $brand
            ],200);
    }
}
