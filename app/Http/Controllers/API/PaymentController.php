<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use App\Customer;

class PaymentController extends Controller
{
    public $_api_context;

    public function __construct()
    {
        $paypalConf = \Config::get('paypal');
        $this->_api_context = new ApiContext( new OAuthTokenCredential( $paypalConf['client_id'], $paypalConf['secret'] ) );
        $this->_api_context->setConfig($paypalConf['settings']);
    }

    public function create_payment(Request $request)
    {       
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->amount);
        $amount->setCurrency('INR');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItem;

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl( $request->return_url )
                    ->setCancelUrl( $request->return_url );

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        $response = $payment->create($this->_api_context);

        $customer = Customer::find($request->customer_id);

        $customer->transaction_id = $payment->getId();

        if ($customer->update()) {
            return $response;           
        } else {
            return response()->json([
                'message' => "Something went wrong"
            ]);
        }        
    }

    public function execute_payment(Request $request)
    {
        $payment_id = $request->payment_id;
        $payer_id = $request->payer_id;

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId( $payer_id );

        $result = $payment->execute($execution, $this->_api_context);

        if ( $result->getState() == "approved" ) {
            if ($result->transactions[0]->related_resources[0]->sale->state == 'completed') {
                $customer = Customer::where('transaction_id', $payment_id)->first();

                if ( isset( $customer->id ) ) {
                    $customer->is_paid = 'yes';
                    $customer->subscription_started_on = time();
                    $customer->subscription_end_on = strtotime('+1 year');

                    $customer->update();

                    return response()->json([
                        'status' => 'success'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error'
                    ], 400); 
                } 
            }         
        }

        return response()->json('failed', 400);
    }
}
