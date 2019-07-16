<?php

namespace App\Http\Controllers\API;

use App\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->Validate($request, [
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required'],
        ]);
        return Product::create([
            'product_name' => $request['product_name'],
            'price' => $request['price'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $product = Product::findOrfail($id);

        $this->Validate($request, [
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required'],
        ]);

        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $product = Product::findOrfail($id);

        $product->delete();
    }
}
