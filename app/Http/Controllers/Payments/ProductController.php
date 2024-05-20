<?php

namespace App\Http\Controllers\Payments;

use App\Enums\Api\HttpResponseCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use Laravel\Cashier\Cashier;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Cashier::stripe()->products->all();
        $productData = collect($products->data)->toArray();

        return response()->json(['data' => $productData, 'message' => 'prodcuts retrieved successfully'], HttpResponseCodes::HttpOK->value);
    }

    public function prices(): JsonResponse
    {
        return response()->json(['message' => 'Prices retrieved successfully']);
    }

    public function productsWithPrices(): JsonResponse
    { {
            $products = Cashier::stripe()->products->all();

            $formattedProducts = collect($products->data)->map(function ($product) {
                $prices = Cashier::stripe()->prices->all([
                    'product' => $product->id,
                ])->data;

                $formattedPrices = collect($prices)->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'metadata' => $price->metadata,
                        'recurring' => $price->recurring,
                    ];
                })->toArray();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'default_price' => $product->default_price,
                    'prices' => $formattedPrices,
                ];
            });

            return response()->json([
                'data' => $formattedProducts,
                'message' => 'Products retrieved successfully'
            ], HttpResponseCodes::HttpOK->value);
        }
    }

    public function product(): JsonResponse
    {
        return response()->json(['message' => 'Product retrieved successfully']);
    }

    public function price(): JsonResponse
    {
        return response()->json(['message' => 'Price retrieved successfully']);
    }
}
