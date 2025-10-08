<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [];

    public function status() {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function getExpectedBalanceAttribute(){
        $total_incomes = Income::where('account_id', $this->id)->sum('amount');
        $total_expenses = Expense::where('account_id', $this->id)->sum('amount');

        return $total_incomes - $total_expenses;
    }
}
