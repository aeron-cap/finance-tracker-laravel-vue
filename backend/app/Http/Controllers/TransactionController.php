<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function recent(Request $request)
    {
        $user = $request->user();
        
        $expenses = Expense::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function($expense) {
                return [
                    'id' => $expense->id,
                    'description' => $expense->budget_type_name,
                    'date' => $expense->expense_date->format('M d, Y g:i A'),
                    'amount' => (float) $expense->amount,
                    'type' => 'expense',
                    'created_at' => $expense->created_at
                ];
            });
        
        $incomes = Income::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function($income) {
                return [
                    'id' => $income->id,
                    'description' => $income->budget_type_name,
                    'date' => $income->income_date->format('M d, Y g:i A'),
                    'amount' => (float) $income->amount,
                    'type' => 'income',
                    'created_at' => $income->created_at
                ];
            });

        $data = $expenses->concat($incomes)
            ->sortByDesc('id')
            ->take(5)
            ->values();
        
        return response()->json($data);
    }
}
