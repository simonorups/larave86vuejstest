<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();

        // var_dump($data);

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        if (!auth()->attempt($data)) {
            return response()->json(['status' => 401, 'message' => 'Login credentials are invaild'], 401);
        }

        //$user = auth()->user();
        $user = $request->user();

        $details = new \stdClass();
        $details->name = $user->name;
        // $details->lname = $user->lname;
        $details->email = $user->email;
        //$details->phone = $user->phone;

        return response()->json(['status' => 200, 'message' => 'Login Successfull', 'details' =>$details], 200);

    }

    /* public function logout(Request $request)
    {      
        $user = $request->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }
        
        //$user->guard()->logout();
        auth()->guard()->logout();
        
        return response()->json(['status' => 200, 'message' => 'User logged out successfully.'], 200);
    } */
}
