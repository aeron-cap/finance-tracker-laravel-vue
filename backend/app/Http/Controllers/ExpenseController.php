<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $expense = Expense::where('user_id', $user->id)->get();

        if (!$expense) {
            return response()->json([
                'message' => 'No expense found',
            ], 204);
        }

        return response()->json([
            'message' => 'Expense found',
            'expense' => $expense,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        $expense = $request->validate([
            'expense_date' => 'required',
            'budget_type_id' => 'required|numeric',
            'budget_type_name' => 'required',
            'account_id' => 'required|numeric',
            'account_name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'status_id' => 'required|numeric',
            'status_name' => 'required',
        ]);

        $e = auto_create(Expense::class, $expense, ['user_id' => $user->id]);

        if ($e->save()) {
            return response()->json([
                'message' => 'Expense created successfully',
                'expense' => $e,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to create expense'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        $user = $request->user();
        $expense = Expense::where('id', $id)->where('user_id', $user->id)->first();

        if (!$expense) {
            return response()->json([
                'message' => 'Expense not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Expense found',
            'expense' => $expense,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = $request->user();

        $expense = $request->validate([
            'expense_date' => 'required',
            'budget_type_id' => 'required|numeric',
            'budget_type_name' => 'required',
            'account_id' => 'required|numeric',
            'account_name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'status_id' => 'required|numeric',
            'status_name' => 'required',
        ]);

        $existing_e = expense::where('id', $id)->first();

        $e = auto_update($existing_e, $expense, ['user_id' => $user->id]);

        if ($e->update()) {
            return response()->json([
                'message' => 'Expense edited successfully',
                'expense' => $e,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to edit expense'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
