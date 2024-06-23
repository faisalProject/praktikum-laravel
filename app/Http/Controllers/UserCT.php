<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserCT extends Controller
{
    public function login( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ] );

        if ( $validator->fails() ) {
            return response()->json( $validator->messages() )->setStatusCode(422);
        }

        $validated = $validator->validated();

        if ( Auth::attempt( $validated ) ) {

            $user = Auth::user();

            $payload = [
                'name' => $user->name,
                'role' => $user->role,
                'iat' => Carbon::now()->timestamp,
                'exp' => Carbon::now()->timestamp + 60 * 60 * 2
            ];

            $bearer = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');

            return response()->json([
                "nama" => $user->name,
                "role" => $user->role,
                "bearer" => $bearer
            ], 200);
        }

        return response()->json("Email atau password salah", 422);
    }

    public function getUserById( Request $request, $id)
    {
        $user = User::find($id);

        // $user = DB::select("SELECT * FROM users WHERE id = $id");

        User::create( $request->all() );

        if ( $user ) {
            return response()->json([
                'message' => "User dengan id: {$id}",
                'data' => $user
            ], 200);
        }

        return response()->json("User dengan id: {$id} tidak ditemukan", 404);

    }

    public function getHTML() {
        $data = "<div style='display: flex; justify-content: center; align-items: center; position: fixed; left: 0; top: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,1)'><h1 style='font-size: 80px; color: red'>ANDA TELAH DI HACK!</h1></div>";

        return view('welcome', compact('data'));
    }    
}
