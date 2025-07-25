<?php

namespace App\Http\Controllers;

use App\Models\BudgetType;
use Illuminate\Http\Request;

class BudgetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $budget_types = BudgetType::all();

        if ($budget_types->isEmpty()) {
            return response()->json([
                'message' => 'No budget types found',
            ], 204);
        }

        return response()->json([
            'message' => 'Budget Types found',
            'budget_types' => $budget_types,
        ], 200);
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
