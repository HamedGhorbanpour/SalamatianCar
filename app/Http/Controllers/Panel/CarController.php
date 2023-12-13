<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Requests\Car\CreateCarRequest;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->has('perPage') ? $request->perPage : 15;
        $cars = Car::with('brand')->when($search, function ($query, $search) {
            return $query->where('model', 'LIKE', "%{$search}%")
                ->orWhere('kind', 'LIKE', "%{$search}%");
        })->paginate($perPage);
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCarRequest $request)
    {
        $car = Car::create($request->all() + ['user_id' => auth()->id()]);
        $car->load('brand');
        return response()->json([
            'message' => 'محصول جدید اضافه شد' ,
            'data' => $car
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with('brand')->findOrfail($id);
        return response()->json([
            'data' => $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, string $id)
    {
        $car = Car::with('brand')->findOrfail($id);
            $car->fill($request->only([
                'model' , 'kind' , 'price' , 'lowest-down-payment' , 'brand_id'
            ]));
            $car->save();
            return response()->json([
                'message' => 'اطلاعات محصول با موفقیت بروزرسانی شد' ,
                'data' => $car
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrfail($id);
            $car->delete();
            return response()->json([
                'message' => 'محصول با موفقیت حذف شد'
            ],200);
    }
}
