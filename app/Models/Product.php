<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'nombre',
		'descripcion',
		'codigo',
		'precio',
		'foto',
		'talla',
		'category_id'
	];

    public static function getRules(){
    	$rules = ['nombre' => 'required'];

    	return $rules;
    }
    public static function getMessages(){
    	$messages = ['nombre.required' => 'El nombre del producto es requerido porque yolo'];

    	return $messages;
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }
}
