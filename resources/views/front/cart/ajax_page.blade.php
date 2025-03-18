@if(Session::has("cart"))
    <div class="col-lg-8">
        <div class="fp__cart_list">
            <div class="table-responsive">
                <table id="exampl e">
                    <tbody>
                        <tr>
                            <th class="fp__pro_img">Image</th>
                            <th class="fp__pro_name">details</th>
                            <th class="fp__pro_status">price</th>
                            <th class="fp__pro_select">quantity</th>
                            <th class="fp__pro_tk">total</th>
                            <th class="fp__pro_icon"><a class="clear_all" role="button">clear all</a></th>                                
                        </tr>
                        @foreach(Session::get("cart")["cart"] as $product)
                            <tr data-product-id="{{ $product["id"] }}">
                                <td class="fp__pro_img"><img src="{{ asset("uploads/product") }}/{{ $product["image"] }}" alt="{{ $product["name"] }}" class="img-fluid w-100"></td>
        
                                <td class="fp__pro_name">
                                    <a href="{{ route("front.product",[$product["id"], $product["slug"]]) }}">{!! $product["name"] !!}</a>
                                    @if(isset(Session::get("cart")["cart"]["size"]))
                                        <span>{{ $product["size"]["name"] }}</span>
                                    @endif
                                    @if(isset(Session::get("cart")["cart"]["options"]))
                                        @foreach($product["options"] as $option)
                                            <p>{!! $option["name"] !!}</p>
                                        @endforeach
                                    @endif
                                </td>
        
                                <td class="fp__pro_status">
                                    <h6>{!! currency($product["price"]) !!}</h6>
                                </td>
        
                                <td class="fp__pro_select">
                                    <div class="quentity_btn">
                                        <button class="btn btn-primary cart_decrease" style="background: #f86f03"><i class="fal fa-minus"></i></button>
                                        <input type="text" id="quantity" name="quantity" placeholder="1" readonly value="{{ $product["quantity"] }}">
                                        <button class="btn btn-primary cart_increase" style="background: #f86f03"><i class="fal fa-plus"></i></button>
                                    </div>
                                </td>
        
                                <td class="fp__pro_tk">
                                    <h6 id="total_price" data-price="{{ $product["price"] }}">
                                        {{ currency(cartItemSubTotal($product["id"])) }}
                                    </h6>
                                </td>
        
                                <td class="fp__pro_icon">
                                    <span data-product-id="{{ $product['id'] }}" class="delete_cart_item text-center" role="button">
                                        <i class="far fa-times"></i>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="fp__cart_list_footer_button">
            <h6>total cart</h6>
            <p>subtotal: <span class="cart_subtotal">{{ currency(cartSubTotal()) }}</span></p>
            <p>delivery: <span class="cart_delivery">{{ currency(0) }}</span></p>
            <p>discount: <span class="cart_discount">
                @if(isset(Session::get("cart")["coupon"]["discount"]))
                    {{ currency(Session::get("cart")["coupon"]["discount"]) }}
                @else
                    {{ currency(0) }}
                @endif
            </span></p>
            <p class="total"><span>total:</span> <span class="cart_total">{{ currency(cartTotalExcludingShipping()) }}</span></p>
            <form>
                <input type="text" placeholder="Coupon Code" name="code">
                <button id="coupon_apply" name="coupon_apply" type="submit">apply</button>
            </form>
            <div id="add_coupon_html">
                @if(isset(Session::get("cart")["coupon"]["code"]))
                    <div class="card mt-4 mb-2">
                        <div class="m-2">
                            <span><b>{{ Session::get("cart")["coupon"]["code"] }}</b></span>
                            <span>
                                <button><i class="far fa-times"></i></button>
                            </span>
                        </div>
                    </div>
                @endif
            </div>
            <a class="common_btn" href="{{ route("front.order.checkout.view") }}">checkout</a>
        </div>
    </div>
@else
    <p class="alert alert-info">Your cart is empty! <a href="{{ route("front.index") }}" class="fw-bolder">Start shopping now.</a></p>
@endif