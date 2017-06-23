<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function articles(){
    	return $this->hasMany(SaleArticle::class);
    }
    public function payments(){
    	return $this->hasMany(Payment::class);
    }
}
