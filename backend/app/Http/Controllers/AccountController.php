<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $accounts = Account::where('user_id', $user->id)->get();

        if (!$accounts) {
            return response()->json([
                'message' => 'No accounts found',
            ], 204);
        }

        return response()->json([
            'message' => 'Accounts found',
            'accounts' => $accounts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        $account = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status_id' => 'required',
        ]);

        $a = auto_create(Account::class, $account, ['user_id' => $user->id]);

        if ($a->save()) {
            return response()->json([
                'message' => 'Account created successfully',
                'account' => $account,
            ], 201);

        } else {
            return response()->json(['message' => 'Failed to create account'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        $user = $request->user();
        $account = Account::where('id', $id)->with('status')->where('user_id', $user->id)->first();

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

        $account = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status_id' => 'required',
        ]);

        $existing_a = Account::where('id', $id)->first();

        $a = auto_update($existing_a, $account, ['user_id' => $user->id]);

        if ($a->update()){
          return response()->json([
              'message' => 'Account updated successfully',
              'account' => $a,
          ], 201);
        } else {
          return response()->json(['message' => 'Failed to edit account'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        //
      $account = Account::find($id);

      if (!$account) {
        return response()->json([
          'message' => 'Account not found',
        ], 404);
      } else {
        $account->delete();

        return response()->json([
          'message' => 'Account deleted',
        ], 200);
      }
    }
}
