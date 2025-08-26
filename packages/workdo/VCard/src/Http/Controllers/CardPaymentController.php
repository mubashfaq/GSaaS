<?php

namespace Workdo\VCard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\VCard\Entities\CardPayment;
use Workdo\VCard\Entities\Business;
use Illuminate\Http\RedirectResponse;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;


class CardPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('vcard::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('vcard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('vcard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

     public function cardPayWithStripe(Request $request, $id)
    {
        $paymentData = CardPayment::cardPaymentData($id);
        $business = Business::find($id);
        $workspace = $business->workspace;
         $company_id = $business->created_by;
        
        $amount = $paymentData->payment_amount;
        $content = json_decode($paymentData->content);
        $stripe_key = $content->stripe->stripe_key;
        $stripe_secret = $content->stripe->stripe_secret;
         $currancy =      company_setting('defult_currancy', $company_id, $workspace)?? 'USD';
        // Ensure minimum amount requirement
        $minimum_amounts = [
            'INR' => 42,   // ₹42 (~$0.50 USD)
            'USD' => 0.50, // $0.50 USD
            'AUD' => 0.50, // $0.50 AUD
            'PKR' => 250,  // ₨250 (~$0.50 USD)
             'AED' => 2,    // 1 AED (~$0.27 USD)
        ];
        
        $minimum_amount = $minimum_amounts[$currancy] ?? 0.50;
        if ($amount < $minimum_amount) {
            return redirect()->back()->with('error', __("The minimum payment amount is $currancy $minimum_amount."));
        }
        
        // Format Stripe price correctly
        $needs_smallest_unit = !in_array($currancy, [
            'MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY',
            'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF'
        ]);
        
        $stripe_formatted_price = $needs_smallest_unit ? intval($amount * 100) : intval($amount);
        
        $return_url_parameters = function ($return_type) {
            return '&return_type=' . $return_type . '&payment_processor=stripe';
        };
        
        /* Initiate Stripe */
        \Stripe\Stripe::setApiKey($stripe_secret);
        
        $product = $business->title;
        $stripe = new \Stripe\StripeClient($stripe_secret);
        
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($currancy),
                    'product_data' => [
                        'name' => $product,
                    ],
                    'unit_amount' => $stripe_formatted_price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route(
                'card.stripe',
                [
                    'cardpayment_id' => $paymentData->id,
                    'business_id' => $business->id,
                    $return_url_parameters('success'),
                ]
            ),
            'cancel_url' => route(
                'card.stripe',
                [
                    'cardpayment_id' => $paymentData->id,
                    'business_id' => $business->id,
                    $return_url_parameters('cancel'),
                ]
            ),
        ]);
        
        try {
            return new RedirectResponse($checkout_session->url);
        } catch (\Exception $e) {
            return redirect(url('cards/' . $business->slug))->with('error', __('Transaction has been failed!.'));
        }

    }








    // public function cardPayWithStripe(Request $request, $id)
    // {
        
        
    //     $paymentData = CardPayment::cardPaymentData($id);
    //     $business = Business::find($id);
    //     $workspace= $business->workspace;
    //     $company_id= $business->created_by;
    //     $amount = $paymentData->payment_amount;
    //     $content = json_decode($paymentData->content);
    //     $stripe_key = $content->stripe->stripe_key;
    //     $stripe_secret = $content->stripe->stripe_secret;
    //      $currancy = 'AUD';
    //     ///
    //     // $currancy =    company_setting('defult_currancy', $company_id, $workspace) ?? 'USD';
        
    //     // $minimum_amounts = [
    //     //         'INR' => 42,   // ₹42 (~$0.50 USD)
    //     //         'USD' => 0.50, // $0.50 USD
    //     //         'AUD' => 0.50, // $0.50 AUD
    //     //         'PKR' => 250,  // ₨250 (~$0.50 USD)
    //     //     ];
            
    //     //     $minimum_amount = $minimum_amounts[$currancy] ?? 0.50; // Default to $0.50 if currency is not listed
            
    //     //     if ($amount < $minimum_amount) {
    //     //         return redirect()->back()->with('error', __("The minimum payment amount is $currency $minimum_amount."));
    //     //     }
        
        
        
    //     /* Final price */
    //     $stripe_formatted_price = in_array(
    //         $currancy,
    //         [
    //             'MGA',
    //             'BIF',
    //             'CLP',
    //             'PYG',
    //             'DJF',
    //             'RWF',
    //             'GNF',
    //             'UGX',
    //             'JPY',
    //             'VND',
    //             'VUV',
    //             'XAF',
    //             'KMF',
    //             'KRW',
    //             'XOF',
    //             'XPF',
    //         ]
    //     ) ? number_format($amount, 2, '.', '') : number_format($amount, 2, '.', '') * 100;

    //     $return_url_parameters = function ($return_type) {
    //         return '&return_type=' . $return_type . '&payment_processor=stripe';
    //     };

    //     /* Initiate Stripe */
    //     \Stripe\Stripe::setApiKey($stripe_secret);
    //     $code = '';
    //     $product = $business->title;
    //     $stripe = new \Stripe\StripeClient($stripe_secret);
    //     $checkout_session = $stripe->checkout->sessions->create([
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'inr',
    //                 'product_data' => [
    //                     'name' => $product,
    //                 ],
    //                 'unit_amount' => $stripe_formatted_price,
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment',
    //         'success_url' => route(
    //             'card.stripe',
    //             [
    //                 'cardpayment_id' => $paymentData->id,
    //                 'business_id' => $business->id,
    //                 $return_url_parameters('success'),
    //             ]
    //         ),
    //         'cancel_url' => route(
    //             'card.stripe',
    //             [
    //                 'cardpayment_id' => $paymentData->id,
    //                 'business_id' => $business->id,
    //                 $return_url_parameters('cancel'),
    //             ]
    //         ),


    //     ]);

    //     $checkout_session = $checkout_session ?? false;

    //     try {
    //         return new RedirectResponse($checkout_session->url);
    //     } catch (\Exception $e) {
    //         return redirect(url('cards/' . $business->slug))->with('error', __('Transaction has been failed!.'));
    //     }
    // }
    
    
    
    
    
    
    
    public function cardGetStripePaymentStatus(Request $request)
    {
        $cardPayment=CardPayment::cardPaymentData($request->business_id);
        $business=Business::find($request->business_id);
        $content=json_decode($cardPayment->content);
        if($request->return_type=='success')
        {
            $cardPayment->payment_status='Paid';
            $cardPayment->payment_type=__('Stripe');
            $cardPayment->save();
            return redirect(url('cards/' . $business->slug))->with('success', 'Payment added succesfully');
        }else
        {
            return redirect(url('cards/' . $business->slug))->with('error', 'Something went wrong.');
        }
    }

    public function cardPayWithPaypal(Request $request,$id)
    {
        $paymentData=CardPayment::cardPaymentData($id);
        $business=Business::find($id);
        $amount=$paymentData->payment_amount;
        $content=json_decode($paymentData->content);
        $paypal_mode=$content->paypal->paypal_mode;
        $paypal_client_id=$content->paypal->paypal_client_id;
        $paypal__secret_key=$content->paypal->paypal_secret_key;
        if($paypal_mode == 'live'){
            config([
                'paypal.live.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                'paypal.live.client_secret' => isset($paypal__secret_key) ? $paypal__secret_key : '',
                'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',
            ]);
        }else{
            config([
                'paypal.sandbox.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                'paypal.sandbox.client_secret' => isset($paypal__secret_key) ? $paypal__secret_key : '',
                'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',
            ]);
        }
        $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('card.get.payment.status', [$id]),
                    "cancel_url" =>  route('card.get.payment.status', [$id]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" =>'usd',
                            "value" => $amount
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect(url('cards/' . $business->slug))->with('error', 'Something went wrong.');
            } else {
                return redirect(url('cards/' . $business->slug))->with('error', $response['message'] ?? 'Something went wrong.');
            }

    }
    public function cardGetPaymentStatus(Request $request, $business_id)
    {
        
        $cardPayment=CardPayment::cardPaymentData($business_id);
        $business=Business::find($business_id);
        $content=json_decode($cardPayment->content);
        $paypal_mode=$content->paypal->paypal_mode;
        $paypal_client_id=$content->paypal->paypal_client_id;
        $paypal__secret_key=$content->paypal->paypal_secret_key;

        if($paypal_mode == 'live'){
            config([
                'paypal.live.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                'paypal.live.client_secret' => isset($paypal__secret_key) ? $paypal__secret_key : '',
                'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',
            ]);
        }else{
            config([
                'paypal.sandbox.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                'paypal.sandbox.client_secret' => isset($paypal__secret_key) ? $paypal__secret_key : '',
                'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',
            ]);
        }
        $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
            $payment_id = Session::get('paypal_payment_id');
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $cardPayment->payment_status='Paid';
                $cardPayment->payment_type=__('Paypal');
                $cardPayment->save();
                return redirect(url('cards/' . $business->slug))->with('success', 'Payment added succesfully');
            }
            else{
                return redirect(url('cards/' . $business->slug))->with('error', 'Transaction has been failed!.');
            }
            
    }
}
