<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\TruckSubunit;
use App\Http\Requests\StoreTruckSubunitRequest;
use App\Http\Requests\UpdateTruckSubunitRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TruckSubunitController extends Controller
{
    /**
     * Display a listing of the subunits.
     */
    public function index(Request $request): JsonResponse
    {
        $truck = request('truck');
        $truckId = Truck::getIdFromName(strtoupper($truck));
        
        $queryBuilder = TruckSubunit::query();
        if($truckId){
            $queryBuilder->where('main_truck_id', $truckId)->orWhere('subunit_id', $truckId);
        }
        return response()->json(
            $queryBuilder->get()->toArray()
        );
    }

    /**
     * Store a newly created subunit in storage.
     */
    public function store(StoreTruckSubunitRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $created = TruckSubunit::create($validated);
        $created['main_truck'] = $validated['main_truck'];
        $created['subunit'] = $validated['subunit'];
        return response()->json($created, 201);
    }

    /**
     * Display a subunit.
     */
    public function show(TruckSubunit $subunit): JsonResponse
    {
        return response()->json($subunit);
    }

    /**
     * Update a subunit in storage.
     */
    public function update(UpdateTruckSubunitRequest $request, TruckSubunit $subunit): JsonResponse
    {
        $validated = $request->validated();
        $subunit->update($validated);
        return response()->json($subunit, 200);
    }

    /**
     * Remove the specified subunit from storage.
     */
    public function destroy(TruckSubunit $subunit): Response
    {
        $subunit->delete();
        return response()->noContent(200);
    }
}
