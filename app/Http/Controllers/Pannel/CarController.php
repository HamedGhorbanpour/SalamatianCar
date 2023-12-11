<?php

namespace App\Http\Controllers\Pannel;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Requests\Car\CreateCarRequest;
use App\Models\Car;
use Illuminate\Support\Facades\Gate;

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
        return response()->json([
            'message' => 'New Car Created Successfully' ,
            'data' => new CarResource($car)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Car::with('brand')->findOrfail($id);
        return response()->json([
            'data' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, string $id)
    {
        $car = Car::findOrfail($id);
            $car->fill($request->only([
                'model' , 'kind' , 'price' , 'lowest-down-payment' , 'brand_id'
            ]));
            $car->save();
            return response()->json([
                'message' => 'Car With ID:' . $id . ' Updated Successfully' ,
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
                'message' => 'Car With ID:'.$id.' Deleted Successfully'
            ],200);
    }
}
