<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Percent\UpdatePercentRequest;
use App\Models\Percent;
use Illuminate\Http\Request;

class PercentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $percents = Percent::all();
        return response()->json($percents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePercentRequest $request)
    {
        $percents = Percent::findOrfail(1);
        $percents->fill($request->all());
        $percents->save();
        return response()->json([
            'message' => 'اطلاعات با موفقیت بروزرسانی شد' ,
            'data' => $percents
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
