<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleArticle extends Model
{
    protected $table = 'salesArticles';

    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
