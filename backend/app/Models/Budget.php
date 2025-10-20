<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];

    // protected $appends = ['budget_used'];

    public function budget_details() {
        return $this->hasMany(BudgetDetail::class, 'budget_id', 'id');
    }

    public function cutoff() {
        return $this->hasOne(CutoffType::class, 'id', 'cutoff_type');
    }

    public function budget_type() {
        return $this->hasOne(BudgetType::class, 'id', 'budget_type_id');
    }
}
