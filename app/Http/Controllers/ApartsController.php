<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleArticle;

class ApartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Apart::with('sale.articles','sale.articles.product','sale','customer')
            ->where('status','Active')
            ->paginate(20);

        return $sales;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apart = Apart::find($id)
            ->with('sale.articles','sale.articles.product','sale','customer')
            ->first();

        foreach($apart->sale->articles as $product){
            $stock = Product::find($product->product_id);
            $stock->stock = $stock->stock + $product->quantity;
            $stock->save();
        }

        Apart::destroy($id);
    }
}
