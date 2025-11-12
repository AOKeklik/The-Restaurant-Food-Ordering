<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderService{
    /* stre order in databse */
    static function create(){
       try {
            $cart=session()->get("cart",[]);
            $cartItems=$cart["cart"] ?? [];
            $cartCoupon=$cart["coupon"] ?? [];
            $cartAddress=$cart["address"] ?? NULL;

            if (!$cartAddress)
                throw new \Exception("Missing required cart data.");

            $order = new Order();
            
            $order->user_id=Auth::guard("user")->user()->id;
            $order->address_id=$cartAddress["id"];
            $order->invoice_id=paymentInvoiceId();
            $order->transaction_id=NULL;
            $order->payment_method=NULL;
            // $order->payment_status="pending";
            // $order->order_status="pending";
            $order->payment_approve_date=NULL;
            $order->currency_name=NULL;  
            $order->discount=empty($cartCoupon) ? 0 : $cartCoupon["discount"];
            $order->delivery_charge=$cartAddress["fee"];
            $order->cart_subtotal=cartSubTotal();
            $order->cart_total=cartTotal();
            $order->product_quantity=cartItemCount();
            $order->coupon_info=empty($cartCoupon) ? NULL : json_encode($cartCoupon);
            $order->address=$cartAddress["address"];

            if(!$order->save()) throw new \Exception("Failed to save order.");

            foreach($cartItems as $item){
                $orderItem = new OrderItem();
    
                $orderItem->order_id=$order->id;
                $orderItem->product_id=$item["id"];
                $orderItem->product_name=$item["name"];
                $orderItem->price=$item["price"];
                $orderItem->qty=$item["quantity"];

                $orderItem->product_size=empty($item["size"]) ? NULL : json_encode($item["size"]);
                $orderItem->product_option=empty($item["options"]) ? NULL : json_encode($item["options"]);

                if(!$orderItem->save())
                    throw new \Exception("Failed to save order item.");
            }

            return $order;
       }catch(\Exception $err){
            throw new \Exception($err->getMessage());
       }
    }
}