<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Phone;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCT extends Controller
{
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,drug',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ] );

        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(422);
        }

        $validated = $validator->validated();

        Product::create( $validated );

        return response()->json("Data berhasil disimpan", 200);
    }

    public function show() {

        $products = Product::with('categories')->get();

        foreach ( $products as $product ) {
            echo '<ul>';
                echo '<li>'. $product->product_name .'</li>';
                echo '<li>'. $product->product_price .'</li>';

                foreach ( $product->categories as $category ) {
                    echo '<ul>';
                        echo '<li>'. $category->category_name .'</li>';
                    echo '</ul>';
                }

            echo '</ul>';
        }

        // return response()->json([
        //     'message' => 'Data Produk',
        //     'data' => $products
        // ], 200);
    }

    public function showById( $id ) {
        $product = Product::find( $id );

        $product = DB::select(" SELECT * FROM products WHERE id = $id ");

        if ( $product ) {
            return response()->json([
                "data" => $product
            ], 200);
        }

        return response()->json("Data dengan id: {$id} tidak ditemukan", 404);   
    }

    public function update( Request $request, $id ) {
        $validator = Validator::make( $request->all(),[
            'product_name' => 'sometimes|max:50',
            'product_type' => 'sometimes|in:snack,drink,drug',
            'product_price' => 'sometimes|numeric',
            'expired_at' => 'sometimes|date'
        ] );

        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(422);
        }

        $validated = $validator->validated();
        $product = Product::find( $id );

        if ( $product ) {
            Product::where( 'id', $id )->update($validated);

            return response()->json("Data dengan id: {$id} berhasil di update", 200);
        }

        return response()->json("Data dengan id: {$id} tidak ditemukan", 404);
    }

    public function delete( $id ) {
        $product = Product::find( $id );

        if ( $product ) {
            Product::where( 'id', $id )->delete();

            return response()->json("Data dengan id: {$id} berhasil di hapus", 200);
        }

        return response()->json("Data dengan id: {$id} tidak ditemukan", 404);
    }

    public function restore( $id ) {
        $product = Product::onlyTrashed()->where('id', $id);
        $product->restore();

        return response()->json("Data dengan id: {$id} berhasil dipulihkan", 200);
    }
}
