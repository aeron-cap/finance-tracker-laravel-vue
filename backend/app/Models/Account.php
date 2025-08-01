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
}
