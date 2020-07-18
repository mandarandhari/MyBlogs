<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Customer;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'alpha_num', 'min:8'],
            'confirmPassword' => ['required', 'same:password']
        ]);

        $customer = new Customer;

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->password = Hash::make($request->password);

        if ( $customer->save() ) {
            if ( Auth::attempt( [ 'email' => $request->email, 'password' => $request->password ] ) ) {
                return response()->json([
                    'success' => TRUE,
                    'token' => Auth::user()->createToken('MyBlogsToken')->accessToken,
                    'customer' => Auth::user()
                ]);
            }
        } else {
            return response()->json([
                'success' => FALSE
            ]);
        }
    }

    public function signin(Request $request) 
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'alpha_num', 'min:8']
        ]);

        if (Auth::attempt( [ 'email' => $request->email, 'password' => $request->password ] )) {
            return response()->json([
                'success' => TRUE,
                'customer' => Auth::user(),
                'token' => Auth::user()->createToken('MyBlogsToken')->accessToken
            ]);
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => "Invalid credentials"
            ]);
        }        
    }

    public function logout()
    {
        if ( isset( Auth::guard('api')->user()->id ) ) {
            if ( Auth::guard('api')->user()->token()->revoke() ) {
                return response()->json([
                    'success' => TRUE
                ]);
            }
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => "Customer does not exists"
            ]);
        }        
    }

    public function update_profile(Request $request) 
    {
        if ( isset( Auth::guard('api')->user()->id ) ) {
            $validation_array = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255']
            ];

            if ( $request->password != "" || $request->confirmPassword != "" ) {
                $validation_array['password'] = ['required', 'alpha_num', 'min:8'];
                $validation_array['confirmPassword'] = ['required', 'alpha_num', 'same:password'];
            }

            $request->validate($validation_array);

            $customer = Customer::find(Auth::guard('api')->user()->id);

            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            
            if ( $request->password != "" ) {
                $customer->password = Hash::make($request->password);
            }

            if ( $customer->update() ) {
                return response()->json([
                    'success' => TRUE,
                    'customer' => $customer,
                    'message' => "Profile updated"
                ]);
            } else {
                return response()->json([
                    'success' => FALSE,
                    'message' => "An unexpected error occured"
                ]); 
            }            
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => "You are not authorized"
            ]);
        }
    }
}
