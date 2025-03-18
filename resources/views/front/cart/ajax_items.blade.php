<div class="fp__menu_cart_header">
    <h5>total item (<span>{{ cartItemCount() }}</span>)</h5>
    <span class="close_cart"><i class="fal fa-times"></i></span>
</div>
@if(Session::has("cart"))
    <ul>
    @foreach(Session::get("cart")["cart"] as $key=>$val)
        <li>
            <div class="menu_cart_img">
                <img src="{{ asset("uploads/product") }}/{{ $val["product_info"]["image"] }}" alt="menu" class="img-fluid w-100">
            </div>
            <div class="menu_cart_text">
                <a class="title" href="{{ route("front.product",[$val["product_info"]["id"],$val["product_info"]["slug"]]) }}">{{ $val["product_info"]["name"] }}</a>
                <p class="size">Qty: {{ $val["product_info"]["quantity"] }}</p>
                <p class="size">{{ $val["product_size"]["name"] ?? "Normal" }}</p>
                @if(isset($val["product_options"]))
                    @foreach($val["product_options"] as $option)
                        <span class="extra">{{ $option["name"] }}</span>
                    @endforeach
                @endif
                <p class="price">
                    {{ currency(cartItemSubTotal($val["product_info"]["id"])) }}
                </p>
            </div>
            @if(!Request::is("order/checkout") && !Request::is("order/payment"))
                <span data-product-id="{{  $val["product_info"]["id"] }}" class="del_icon"><i class="fal fa-times"></i></span>
            @endif
        </li>
    @endforeach
    </ul>  
    <p class="subtotal">sub total <span>{{ currency(cartSubTotal()) }}</span></p>
    <a class="cart_view" href="{{ route("front.order.cart") }}"> view cart</a>
    <a class="checkout" href="{{ route("front.order.checkout.view") }}">checkout</a>
@else
    <p>No any items to show in the cart!</p>
@endif
