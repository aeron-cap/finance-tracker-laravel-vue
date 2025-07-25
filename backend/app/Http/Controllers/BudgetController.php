<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetDetail;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $budgets = Budget::where('user_id', $user->id)->with('budget_details', 'cutoff')->get();

        if (!$budgets) {
            return response()->json([
                'message' => 'No budgets found',
            ], 204);
        }

        return response()->json([
            'message' => 'Budgets found',
            'budgets' => $budgets,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $budget = $request->validate([
            'status_id' => 'required',
            'status_name' => 'required',
            'budget_name' => 'required',
            'amount_to_budget' => 'required|numeric',
            'cutoff_type' => 'required',
            'budget_date' => 'required',
        ]);

        $budget_details = $request->validate([
            'budget_details' => 'required|array',
            'budget_details.*.budget_type_id' => 'required',
            'budget_details.*.budget_type_name' => 'required',
            'budget_details.*.description' => 'required',
            'budget_details.*.amount' => 'required|numeric',
            'budget_details.*.is_used' => 'required',
            'budget_details.*.type' => 'required',
        ]);

        $b = auto_create(Budget::class, $budget, ['user_id' => $user->id]);

        if ($b->save()) {
            $details = $budget_details['budget_details'];
            foreach ($details as $detail) {
                $bd = auto_create(BudgetDetail::class, $detail, ['budget_id' => $b->id]);
                $bd->save();
            }

            return response()->json([
                'message' => 'Budget created successfully',
                'budget' => $budget,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to create budget'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        $user = $request->user();
        $budget = Budget::where('id', $id)->with('budget_details', 'cutoff', 'budget_type')->where('user_id', $user->id)->first();

        if (!$budget) {
            return response()->json([
                'message' => 'Budget not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Budget found',
            'budget' => $budget,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        //
        $user = $request->user();
        
        $budget = $request->validate([
            'status_id' => 'required',
            'status_name' => 'required',
            'budget_name' => 'required',
            'amount_to_budget' => 'required|numeric',
            'cutoff_type' => 'required',
            'budget_date' => 'required',
        ]);

        $budget_details = $request->validate([
            'budget_details' => 'required|array',
            'budget_details.*.budget_type_id' => 'required',
            'budget_details.*.budget_type_name' => 'required',
            'budget_details.*.description' => 'required',
            'budget_details.*.amount' => 'required|numeric',
            'budget_details.*.is_used' => 'required',
            'budget_details.*.type' => 'required',
        ]);

        $existing_b = Budget::where('id', $id)->first();

        $b = auto_update($existing_b, $budget, ['user_id' => $user->id]);

        if ($b->update()) {
            BudgetDetail::where('budget_id', $id)->delete();
            $details = $budget_details['budget_details'];
            foreach ($details as $detail) {
                $bd = auto_create(BudgetDetail::class, $detail, ['budget_id' => $id]);
                $bd->save();
            }

            return response()->json([
                'message' => 'Budget edited successfully',
                'budget' => $budget,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to edit budget'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $requestd)
    {
        //
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json([
                'message' => 'Budget not found',
            ], 404);
        } else {
            $budget->delete();
            
            return response()->json([
                'message' => 'Budget deleted',
            ], 200);
        }

    }
}
