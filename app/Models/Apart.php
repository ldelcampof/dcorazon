<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apart extends Model
{
	use SoftDeletes;

    protected $fillable = ['name'];

    public function customer(){
    	return $this->belongsTo(Customer::class);
    }
    public function sale(){
    	return $this->belongsTo(Sale::class);
    }
}
