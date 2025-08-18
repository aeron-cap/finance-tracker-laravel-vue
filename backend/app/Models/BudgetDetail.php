<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    //
    protected $guarded = [];

    public function budget() {
        return $this->hasOne(Budget::class, 'id', 'budget_id');
    }

}
