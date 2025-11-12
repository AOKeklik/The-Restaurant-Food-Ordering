<?php

namespace App\Http\Controllers\Front;

use App\Events\PaypalPaymentEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal;

class FrontPaymentController extends Controller
{
    public function payment_view()
    {

        if(Session::has("cart") && empty(Session::get("cart")["address"]))
            return redirect()->route("front.order.checkout.view")->with("error","Please select an address to proceed to the payment page.");
        
        return view("front.payment.index");
    }

    public function payment_store_ajax(Request $request, OrderService $order)
    {
        try {
            $validator=\Validator::make($request->all(), [
                "payment_method" => "required|string|in:paypal,stripe",
            ]);
    
            if (!$validator->passes())
                return response()->json(["error" => ["message" => $validator->errors()->first()]]);

            $order=$order::create();

            if($order) {
                $cart=session()->get("cart",[]);
                $cart["order"] = [
                    "id"=>$order->id,
                    "total"=>$order->cart_total,
                ];
                session()->put("cart",$cart);

                switch($request->payment_method){
                    case "paypal":
                        return response()->json(["success" => ["message" => "Cart updated successfully","redirect"=>route("front.order.method.paypal.payment")]]);
                    break;
                    case "stripe":
                        return response()->json(["success" => ["message" => "Cart updated successfully","redirect" => route("front.order.method.stripe.payment")]]);
                    break;
                    default: return response()->json(["error" => ["message" => "Invalid payment method."]]);break;
                }
            }

            return response()->json(["error" => ["message" => "Failed to create the order."]]);
        } catch (\Exception $e) {
            return response()->json(["error" => ["message" => $e->getMessage()]]);
        }
    }

    /* paypal */
    public function paypal_config()
    {
        return [
            'mode'=> config("paymentSettings.paypal_account_mode"),
            'sandbox'=> [
                'client_id'=>config("paymentSettings.paypal_api_key"),
                'client_secret'=>config("paymentSettings.paypal_secret_key"),
                'app_id'=>"APP-80W284485P519543T",
            ],
            'live' => [
                'client_id'=>config("paymentSettings.paypal_api_key"),
                'client_secret'=>config("paymentSettings.paypal_secret_key"),
                'app_id'=>config("paymentSettings.paypal_app_id"),
            ],     
            'payment_action'=>"Sale",
            'currency'=>config("paymentSettings.paypal_currency"),
            'notify_url'=>"",
            'locale'=>"pl-PL",
            'validate_ssl'=>false,
        ];
    }
    public function paypal_payment() 
    {
        try{
            $value = optional(session()->get("cart"))["order"]["total"] ?? 0;
            $value *= config("paymentSettings.paypal_rate");
            $value = round($value, 2);

            $config = $this->paypal_config();
            $provider = new PayPal($config);

            $accessToken = $provider->getAccessToken();
            
            if (isset($accessToken['error']))
                throw new \Exception("PayPal authentication failed. Check API credentials.");
            
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route("front.order.method.paypal.success"),
                    "cancel_url" => route("front.order.method.paypal.cancel"),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config("paymentSettings.paypal_currency"),
                            "value" => $value,
                        ]
                    ]
                ],
            ]);

            if (isset($response['error']))
                throw new \Exception($response['error']["message"]);

            if(isset($response["id"]) && $response["id"] != NULL)
                foreach($response["links"] as $link)
                    if($link["rel"] == "approve")
                        return redirect()->away($link["href"]);
            else
                return redirect()->route('front.order.method.paypal.cancel')->withErrors(['error' => $response['error']['message']]);

            // dd($response);
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function paypal_success(Request $request) {
        try{
            $config = $this->paypal_config();
            $provider = new PayPal($config);
            $accessToken = $provider->getAccessToken();
            
            if (isset($accessToken['error']))
                throw new \Exception("PayPal authentication failed. Check API credentials.");

            $response=$provider->capturePaymentOrder($request->token);

            // dd($response);

            if(isset($response['status']) && $response['status'] === 'COMPLETED'){
                $orderId = session()->get("cart")["order"]["id"];
                $order=Order::find($orderId);

                if(!$order)
                    return new \Exception("");

                $order->payment_status="success";
                $order->order_status="success";

                if(!$order->save())
                    return new \Exception("");

                $capture = $response['purchase_units'][0]['payments']['captures'][0];
                $paymentInfo = [
                    'transaction_id' => $capture['id'],
                    'currency' => $capture['amount']['currency_code'],
                    'status' => 'completed'
                ];

                PaypalPaymentEvent::dispatch($orderId,$paymentInfo,"PayPal");
            }
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function paypal_cancel() {

    }

    /* stripe */
    public function stripe_payment(){}
    public function stripe_success(){}
    public function stripe_cancel(){}
}
