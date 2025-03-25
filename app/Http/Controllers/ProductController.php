<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Product::query()->with('categories');
    
            
            if ($request->filled('search')) {
                $validated = $request->validate([
                    'search' => 'sometimes|string|max:255'
                ]);
                
                $searchTerm = Str::lower(trim($validated['search']));
                
                $query->where(function($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                      ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
                });
            }
    
          
            if ($request->filled('sort')) {
                $validatedSort = $request->validate([
                    'sort' => 'in:price_asc,price_desc'
                ]);
                
                $sortParts = explode('_', $validatedSort['sort']);
                $column = $sortParts[0];
                $direction = $sortParts[1];
                
                $query->orderBy($column, $direction);
            }
    
            $products = $query->paginate(6);
    
            return response()->json([
                'success' => true,
                'data' => $products,
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'search' => $request->search ?: null,
                    'sort' => $request->sort ?: ''
                ]
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null
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
    public function show(Product $product)
    {
        $product->load('categories');

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
