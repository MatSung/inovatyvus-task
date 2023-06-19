<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TruckController extends Controller
{
    /**
     * Display a listing of the trucks.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Truck::query()->get()->toArray()
        );
    }

    /**
     * Store a newly created truck in storage.
     */
    public function store(StoreTruckRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return response()->json(Truck::create($validated), 201);
    }

    /**
     * Display a truck.
     */
    public function show(Truck $truck): JsonResponse
    {
        return response()->json($truck);
    }

    /**
     * Update a truck in storage.
     */
    public function update(UpdateTruckRequest $request, Truck $truck): JsonResponse
    {
        $validated = $request->validated();
        $truck->update($validated);
        return response()->json($truck, 200);
    }

    /**
     * Remove the specified truck from storage.
     */
    public function destroy(Truck $truck): Response
    {
        $truck->delete();
        return response()->noContent(200);
    }
}