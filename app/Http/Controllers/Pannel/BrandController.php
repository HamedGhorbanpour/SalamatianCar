<?php

namespace App\Http\Controllers\Pannel;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
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
        $brand = Brand::create($request->all() + ['user_id' => auth()->id()]);
        return response()->json([
            'message' => 'New brand Created Successfully' ,
            'data' => new BrandResource($brand)
        ]);
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
        $allows = Gate::allows('update' , $brand);
        if ($allows) {
            $brand->fill($request->only([
                'name'
            ]));
            $brand->save();
            return response()->json([
                'message' => 'Brand With ID:' . $id . ' Updated Successfully' ,
                'data' => $brand
            ], 200);
        } else {
            return response()->json([
                'message' => 'You dont have permission'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrfail($id);
        $allows = Gate::allows('delete' , $brand);
        if ($allows){
            $brand->delete();
            return response()->json([
                'message' => 'Brand With ID:'.$id.' Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'message' => 'You dont have permission'
            ],403);
        }
    }
}
