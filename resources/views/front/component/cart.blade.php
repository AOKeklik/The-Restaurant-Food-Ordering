<div class="col-lg-4">
    <div class="fp__cart_list_footer_button">
        <h6>total cart</h6>
        <p>subtotal: <span class="cart_subtotal">{{ currency(cartSubTotal()) }}</span></p>
        <p>delivery: <span class="cart_delivery">{{ currency(deliveryFee()) }}</span></p>
        <p>discount: <span class="cart_discount">
            @if(isset(Session::get("cart")["coupon"]["discount"]))
                {{ currency(Session::get("cart")["coupon"]["discount"]) }}
            @else
                {{ currency(0) }}
            @endif
        </span></p>
        <p class="total"><span>total:</span> <span class="cart_total">{{ currency(cartTotal()) }}</span></p>
        @if(!Request::is("order/payment"))
            <a href="javascript:void(0)" data-btn="proceed-payment" class="common_btn">proceed to payment</a>
        @endif
    </div>
</div>