<?php

namespace App\Http\Controllers\Pannel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CreateCarRequest;
use App\Models\Car;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $cars = Car::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('text', 'LIKE', "%{$search}%");
        })->paginate(10);
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCarRequest $request)
    {
        $car = Car::create($request->all() + ['user_id' => auth()->id()])->with('brands');
        return response()->json([
            'message' => 'New Car Created Successfully' ,
            'data' => $car
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Car::findOrfail($id);
        return response()->json([
            'data' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $car = Car::findOrfail($id);
        $allows = Gate::allows('update' , $car);
        if ($allows) {
            $car->fill($request->only([
                'model' , 'kind' , 'category_id' , 'price' , 'lowest-down-payment' , 'brand_id'
            ]));
            $car->save();
            return response()->json([
                'message' => 'Car With ID:' . $id . ' Updated Successfully' ,
                'data' => $car
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
        //
    }
}
