<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Income;

class Budget extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];

    protected $appends = ['budget_used'];

    public function budget_details() {
        return $this->hasMany(BudgetDetail::class, 'budget_id', 'id');
    }

    public function cutoff() {
        return $this->hasOne(CutoffType::class, 'id', 'cutoff_type');
    }

    public function budget_type() {
        return $this->hasOne(BudgetType::class, 'id', 'budget_type_id');
    }

    public function getBudgetUsedAttribute() {
        $incomes = Income::where('budget_id', $this->id)->where('user_id', $this->user_id)->get()->toArray();
        // add expenses later

        if (count($incomes) > 0) {
            return true;
        } else {
            return false;
        }

    }
}
