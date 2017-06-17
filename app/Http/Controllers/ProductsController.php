<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')
            ->paginate(20);

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $product_id = null)
    {
        $data = $request->all();
        $dataProduct = (array) json_decode($data['product']);
        $faker = \Faker\Factory::create();

        Validator::make($dataProduct, Product::getRules(), Product::getMessages())->validate();

        $destinationPath = '/public/uploads/productos';
        $file = $request->filefoto->store($destinationPath);
        $path = str_replace('public/', 'storage/', $file);

        if($product_id == null){
            $product = new Product($dataProduct);
        }else{
            $product = Product::find($product_id);
        }
        $product->slug = substr($faker->md5,0,10);
        $product->foto = $path;
        $product->save();

        return $product;

    }
    /**
     * Store a new stock of products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStock(Request $request, $product_id)
    {
        $data = $request->all();
        $product = Product::find($product_id);
        $product->stock = $product->stock + $data['cantidad'];
        $product->save();

        return $product;
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
        Product::destroy($id);
    }
    /**
     * Busca un producto por su codigo
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $data = $request->all();
        $product = Product::with('category')
            ->where('codigo', 'LIKE', $data['s'])
            ->first();

        return $product;
    }
}
