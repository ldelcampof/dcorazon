<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleArticle;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::where('type', 'Sale')
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $faker = \Faker\Factory::create();

        $sale = new Sale();
        $sale->discount = 0;
        $sale->user_id = 0;
        $sale->slug = substr($faker->md5, 0, 10);
        $sale->subtotal = $data['subtotal'];
        $sale->type = $data['type'];
        $sale->save();

        foreach($data['products'] as $productSale){
            $product = new SaleArticle();
            $product->sale_id = $sale->id;
            $product->product_id = $productSale['id'];
            $product->quantity = $productSale['cantidad'];
            $product->price = $productSale['precio'];
            $product->save();

            $stock = Product::find($productSale['id']);
            $stock->stock = $stock->stock - $productSale['cantidad'];
            $stock->save();
        }

        if($data['type'] == 'Apart'){
            $apart = new Apart();
            $apart->sale_id = $sale->id;
            $apart->status = 'Active';
            $apart->rest = ($sale->subtotal*1.16) - $data['payment'];
            if($data['customer']['type'] == 'New'){
                $customer = Customer::create($data['customer']);
                $apart->customer_id = $customer->id;
            }else{
                $apart->customer_id = $data['customer']['id'];
            }
            $apart->save();
        }

        return $sale;

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
        //
    }
}
