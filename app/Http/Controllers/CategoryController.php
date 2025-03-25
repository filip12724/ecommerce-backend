<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try{

            $categories=Category::all();

            return response()->json([
                'success' => true,
                'data' => $categories,
                'meta' => [
                    'count' => $categories->count()
                ]

            ], 200);

        }catch(\Exception $ex){
            
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred',
                'error' => config('app.debug') ? $ex->getMessage() : null
            ], 500);
        
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
