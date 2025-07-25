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
