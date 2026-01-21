<?php

namespace App\Http\Controllers;

use App\Services\PriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PricingController extends Controller
{
    public function config(): JsonResponse
    {
        return response()->json(config('pricing'));
    }

    public function calculate(Request $request, PriceCalculator $calculator): JsonResponse
    {
        $config = config('pricing');
        $selection = $request->input('selection', []);

        return response()->json($calculator->calculate($config, $selection));
    }
}
