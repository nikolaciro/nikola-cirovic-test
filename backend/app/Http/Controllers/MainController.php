<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Franchise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function companies(): JsonResponse
    {
        return response()->json(Company::all());
    }

    public function franchise(Franchise $franchise): JsonResponse
    {
        return response()->json($franchise);
    }

    public function franchises(Request $request, Company $company): JsonResponse
    {
        $franchises = $company->franchises();
        if ($request->has('order_by')) {
            $orderBy = $request->input('order_by');
            $direction = $request->input('order_dir', 'asc');
            $franchises->orderBy($orderBy, $direction);
        }
        if ($request->has('limit')) {
            $limit = $request->input('limit');
            $franchises->limit($limit);
        }

        return response()->json($franchises->get());
    }
}
