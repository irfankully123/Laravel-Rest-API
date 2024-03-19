<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Pipeline\Pipeline;
use App\Http\Requests\ProductStoreRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{

     /**
     * Products
     * @param Request $request
     * @return JsonResponse
     */
     public function index(Request $request): JsonResponse
    {
        $products = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                \App\Filters\ProductSearch::class,
                \App\Filters\ProductOrderBy::class,
            ])
            ->thenReturn()
            ->paginate(8)
            ->withQueryString();

        return response()->json([
            'products' => $products,
        ], ResponseAlias::HTTP_OK, [], JSON_PRETTY_PRINT);
    }

    /**
     * Single Product
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = Product::where('id', $id)->first();
            if (!empty($product)) {
                return response()->json($product, ResponseAlias::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'product not found'
                ], ResponseAlias::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store this Product
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
          $product= Product::create($request->validated());
            return response()->json([
                'message' => 'Product Created Successfully',
                'data'=> $product
            ], ResponseAlias::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update this Product
     * @param ProductStoreRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductStoreRequest $request, int $id): JsonResponse
    {
        try {
            $product = Product::where('id', $id)->first();
            if (!empty($product)) {
                $product->update($request->validated());
                return response()->json([
                    'message' => 'Product Updated Successfully',
                    'data'=> $product
                ], ResponseAlias::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Product Not Found'
                ], ResponseAlias::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete this Product
     * @param int $id
     * @return JsonResponse
     */

    public function destroy(int $id): JsonResponse
    {
        try {
            $product = Product::where('id', $id)->first();
            if (!empty($product)) {
                $product->delete();
                return response()->json([
                    'message' => 'Product Deleted Successfully'
                ], ResponseAlias::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Product Not Found'
                ], ResponseAlias::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}