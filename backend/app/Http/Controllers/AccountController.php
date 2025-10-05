<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use App\Models\Income;
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
        $accounts = Account::where('user_id', $user->id)->with('status')->get();

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

        $breakdown = null !== $request->get('breakdown') ? $request->get('breakdown') : null;

        if ($breakdown != null) {
          $a = auto_create(Account::class, $account, ['user_id' => $user->id, 'breakdown' => $breakdown]);
        } else {
          $a = auto_create(Account::class, $account, ['user_id' => $user->id]);
        }

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
            'breakdown' => 'nullable|string',
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

    public function update_balance(string $id, Request $request)
    {
        $user = $request->user();
        $account_update = Account::where('id', $id)->where('user_id', $user->id)->first();
        $actual_balance = $request->get('actual_balance');

        if (isset($account_update)) {
            $account_update->update(['actual_balance' => $actual_balance]);
        }

        return response()->json([
            'message' => 'Actual Balance updated'
        ], 200);
    }

    public function show_breakdown(string $id, Request $request)
    {
        $user = $request->user();

        $account = Account::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$account) {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        $breakdown = $account->breakdown ? json_decode($account->breakdown) : null;

        if (!$breakdown) {
            return response()->json([
                'message' => 'No breakdown data available',
                'breakdown_summary' => []
            ], 200);
        }

        $expenses = Expense::where('user_id', $user->id)
            ->where('account_id', $id)
            ->whereIn('budget_type_name', $breakdown)
            ->selectRaw('budget_type_name, SUM(amount) as total_amount, COALESCE(MAX(expense_date), "-") as as_of')
            ->groupBy('budget_type_name')
            ->get()
            ->keyBy('budget_type_name');

        $incomes = Income::where('user_id', $user->id)
            ->where('account_id', $id)
            ->whereIn('budget_type_name', $breakdown)
            ->selectRaw('budget_type_name, SUM(amount) as total_amount, COALESCE(MAX(income_date), "-") as as_of')
            ->groupBy('budget_type_name')
            ->get()
            ->keyBy('budget_type_name');

        $breakdown_summary = [];
        foreach ($breakdown as $type) {
            $expense_total = $expenses->get($type)->total_amount ?? 0;
            $income_total = $incomes->get($type)->total_amount ?? 0;
            $as_of = isset($incomes->get($type)->as_of) ? $incomes->get($type)->as_of : "N/A";

            $breakdown_summary[$type] = [
                'total' => $income_total - $expense_total,
                'income' => $income_total,
                'expense' => $expense_total,
                'as_of' => $as_of,
                'account_id' => $id,
            ];
        }

        return response()->json([
            'account_id' => $account->id,
            'account_name' => $account->name,
            'breakdown_summary' => $breakdown_summary,
        ], 200);
    }
}
