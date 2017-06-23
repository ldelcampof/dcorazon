<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apart;
use App\Models\Payment;
use App\Models\Sale;

class PaymentsController extends Controller
{
    public function index(Request $request, $slug){
    	$sale = Sale::where('slug', $slug)
    		->first();

    	$payments = Payment::where('sale_id', $sale->id)
    		->paginate(20);

    	return $payments;
    }

    public function store(Request $request){
    	$data = $request->all();

    	$sale = Apart::find($data['sale_id']);
    	$data['sale_id'] = $sale->id;
    	$payment = Payment::create($data);
    	$sale->rest -= $data['ammount'];
    	if($sale->rest == 0){
    		$sale->status = 'Payed';
    	}
    	$sale->save();

    	return $payment;
    }
}
