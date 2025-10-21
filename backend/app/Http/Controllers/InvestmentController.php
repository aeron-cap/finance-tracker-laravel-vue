<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $investments = Investment::where('user_id', $user->id)->get();

        if (!$investments) {
          return response()->json([
            'message' => 'Investment does not exist'
          ]);
        }

        return response()->json([
          'message' => 'Investment found',
          'data' => $investments,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        $goal = $request->validate([
          'name' => 'required',
          'budget_id' => 'required',
          'budget_name' => 'required',
          'amount' => 'required|numeric',
          'budget_type_id' => 'required',
          'budget_type_name' => 'required',
          'account_id' => 'required',
          'account_name' => 'required',
          'status_id' => 'required',
          'status_name' => 'required',
          'investment_type_id' => 'required',
          'investment_type_name' => 'required',
        ]);

        $g = auto_create(Investment::class, $goal, ['user_id', $user->id]);

        if ($g->save()) {
          return response()->json([
            'message' => "Investment created successfully.",
            'goal' => $goal,
          ], 201);
        } else {
          return response()->json(['message' => "Failed to create Investment"], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        $user = $request->user();
        $account = Investment::where('id', $id)->with('status')->where('user_id', $user->id)->first();

        if (!$account) {
            return response()->json([
                'message' => 'Account not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Account found',
            'account' => $account,
        ], 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = $request->user();

        $goal = $request->validate([
          'name' => 'required',
          'budget_id' => 'required',
          'budget_name' => 'required',
          'amount' => 'required|numeric',
          'budget_type_id' => 'required',
          'budget_type_name' => 'required',
          'account_id' => 'required',
          'account_name' => 'required',
          'status_id' => 'required',
          'status_name' => 'required',
          'investment_type_id' => 'required',
          'investment_type_name' => 'required',
        ]);

        $existing_g = Investment::where('id', $id)->first();

        $g = auto_update($existing_g, $goal, ['user_id' => $user->id]);

        if ($g->update()){
          return response()->json([
              'message' => 'Investment updated successfully',
              'goal' => $g,
          ], 201);
        } else {
          return response()->json(['message' => 'Failed to edit investment'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        //
      $user = $request->user();

      $investment = Investment::where('id', $id)->where('user_id', $user->id)->first();

      if (!$investment) {
        return response()->json([
          'message' => 'Investment not found',
        ], 404);
      } else {
        $investment->delete();

        return response()->json([
          'message' => 'Investment deleted',
        ], 200);
      }
    }
}
