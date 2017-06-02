<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

	protected $fillable = [
		'nombre',
		'descripcion',
		'codigo',
		'precio',
		'foto',
		'talla',
		'categoria'
	];

    public static function getRules(){
    	$rules = ['nombre' => 'required'];

    	return $rules;
    }
    public static function getMessages(){
    	$messages = ['nombre.required' => 'El nombre del producto es requerido porque yolo'];

    	return $messages;
    }
}
