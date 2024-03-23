<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CarResource;
use App\Models\Car;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return CarResource::collection(Car::get());
    }

    public function show(String $id)
    {
        return CarResource::collection(Car::where('id',$id)->get());
    }

    public function addCar(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'string|required',
            'model' => 'string|required',
            'plate' => 'string|required',
        ]);
        try{
            Car::create([
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'plate' => $validatedData['plate'],
                'user_id' => $request->get('user_id')
            ]);
        }catch (QueryException $e){
            return response()->json([
                'status' => 'error',
                'message' => $e
            ],500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Created Successfully'
        ]);

    }

    public function editCar(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'string|required',
            'model' => 'string|required',
            'plate' => 'string|required',
        ]);
        try{
            Car::where('id',$request->get('car_id'))->update([
                'brand' => $validatedData['brand'],
                'model' => $validatedData['model'],
                'plate' => $validatedData['plate'],
                'user_id' => $request->get('user_id')
            ]);
        }catch (QueryException $e){
            return response()->json([
                'status' => 'error',
                'message' => $e
            ],500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Updated Successfully'
        ]);
    }

    public function deleteCar(String $id)
    {
        try{
            Car::where('id',$id)->delete();
        }catch (QueryException $e){
            return response()->json([
                'status' => 'error',
                'message' => $e
            ],500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ]);
    }
}
