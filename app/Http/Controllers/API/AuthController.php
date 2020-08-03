<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Customer;
use App\ForgotPassword;
use App\Mail\Registration;
use App\Mail\RegistrationAdmin;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Rules\checkCustomerEmail;

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
                Mail::to($customer->email)
                    ->queue(new Registration($customer));

                Mail::to('admin@myblogs.com')
                    ->queue(new RegistrationAdmin($customer));

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

    public function get_customer_data()
    {
        if ( isset(Auth::guard('api')->user()->id) ) {
            $userData = [
                'id' => Auth::guard('api')->user()->id,
                'name' => Auth::guard('api')->user()->name,
                'phone' => Auth::guard('api')->user()->phone,
                'email' => Auth::guard('api')->user()->email,
                'is_paid' => Auth::guard('api')->user()->is_paid,
                'subscription_started_on' => Auth::guard('api')->user()->subscription_started_on,
                'subscription_end_on' => Auth::guard('api')->user()->subscription_end_on,
                'created_at' => Auth::guard('api')->user()->subscription_end_on,
            ];

            return response()->json([
                'success' => TRUE,
                'customer' => $userData
            ]);
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'You are not authorized'
            ]);
        }
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', new checkCustomerEmail]
        ]);

        $forgot_password = new ForgotPassword;

        $forgot_password->email = $request->email;
        $forgot_password->token = Str::random(60);

        if ($forgot_password->save()) {
            Mail::to($forgot_password->email)
                ->queue(new ForgotPasswordMail($forgot_password));

            return response()->json([
                'success' => TRUE,
                'message' => 'Password reset link has been sent to your email address'
            ]);
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'An unexpected error occured'
            ]);
        }
    }

    public function get_customer($token)
    {
        $customer = ForgotPassword::leftJoin('customers', 'customer_password_resets.email', '=', 'customers.email')
                                    ->where('token', $token)
                                    ->first([
                                        'customers.id AS customer_id',
                                        'customer_password_resets.id AS id'
                                    ]);

        if ( isset($customer->id) ) {
            return response()->json([
                'success' => TRUE,
                'customer_id' => $customer->customer_id,
                'token_id' => $customer->id
            ]);
        } else {
            return response()->json([
                'success' => FALSE
            ]);
        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'alpha_num', 'min:8'],
            'confirmPassword' => ['required', 'alpha_num', 'min:8', 'same:password']
        ]);

        $customer = Customer::find($request->customerId);
        $customer_password_reset = ForgotPassword::find($request->token_id);

        if ( isset($customer->id) && isset($customer_password_reset->id) ) {
            $customer->password = Hash::make($request->password);

            if ($customer->update()) {
                $customer_password_reset->delete();

                return response()->json([
                    'success' => TRUE,
                    'message' => 'Password updated successfully'
                ]);
            } else {
                return response()->json([
                    'success' => FALSE,
                    'message' => 'AN unexpected error occured'
                ]);
            }
        } else {
            return response()->json([
                'success' => FALSE
            ]);
        }
    }
}
