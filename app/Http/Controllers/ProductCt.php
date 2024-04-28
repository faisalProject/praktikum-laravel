<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCt extends Controller
{
    public function show()
    {
        $products = Product::all();

        return response()->json([
            'data product' => $products
        ], 200);
    }

    public function create( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,fruit,drug',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ] );


        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(404);
        }

        $validated = $validator->validated();

        Product::create( $validated );

        return response()->json([
            'messagde' => 'Data berhasil disimpan',
        ], 200);
    }
}
