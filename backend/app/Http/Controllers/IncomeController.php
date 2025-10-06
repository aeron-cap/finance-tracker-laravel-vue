<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $skip = $request->get('skip');
        $take = $skip + 30;

        $incomes = Income::skip($skip)->take($take)->orderBy('income_date', 'desc')->where('user_id', $user->id)->get();

        if (!$incomes) {
            return response()->json([
                'message' => 'No incomes found',
            ], 204);
        }

        return response()->json([
            'message' => 'Incomes found',
            'income' => $incomes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        $income = $request->validate([
            'income_date' => 'required',
            'budget_type_id' => 'required|numeric',
            'budget_type_name' => 'required',
            'account_id' => 'required|numeric',
            'account_name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'status_id' => 'required|numeric',
            'status_name' => 'required',
            'budget_id' => 'nullable|numeric',
            'budget_name' => 'nullable'
        ]);

        $i = auto_create(Income::class, $income, ['user_id' => $user->id]);

        if ($i->save()) {
            return response()->json([
                'message' => 'Income created successfully',
                'income' => $i,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to create income'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        $user = $request->user();
        $income = Income::where('id', $id)->where('user_id', $user->id)->first();

        if (!$income) {
            return response()->json([
                'message' => 'Income not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Income found',
            'income' => $income,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = $request->user();

        $income = $request->validate([
            'income_date' => 'required',
            'budget_type_id' => 'required|numeric',
            'budget_type_name' => 'required',
            'account_id' => 'required|numeric',
            'account_name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'status_id' => 'required|numeric',
            'status_name' => 'required',
            'budget_id' => 'nullable|numeric',
            'budget_name' => 'nullable'
        ]);

        $existing_i = Income::where('id', $id)->first();

        $i = auto_update($existing_i, $income, ['user_id' => $user->id]);

        if ($i->update()) {
            return response()->json([
                'message' => 'Income edited successfully',
                'income' => $i,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to edit income'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        //
        $income = Income::find($id);

        if (!$income) {
            return response()->json([
                'message' => 'Income not found',
            ], 404);
        } else {
            $income->delete();

            return response()->json([
                'message' => 'Income deleted',
            ], 200);
        }
    }
}
