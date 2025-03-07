@extends("front.layout.app")
@section("title", "Cart")
@section("page_title", "Cart Detail")
@section("content")

<!--=============================
    BREADCRUMB START
==============================-->
@include("front.component.bread_crumb")
<!--=============================
    BREADCRUMB END
==============================-->


<!--============================
    CART VIEW START
==============================-->
<section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            @if(Session::has("cart"))
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
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
                                    @foreach(Session::get("cart") as $product)
                                        <tr data-product-id="{{ $product["product_info"]["id"] }}">
                                            <td class="fp__pro_img"><img src="{{ asset("uploads/product") }}/{{ $product["product_info"]["image"] }}" alt="{{ $product["product_info"]["name"] }}" class="img-fluid w-100"></td>

                                            <td class="fp__pro_name">
                                                <a href="{{ route("front.product",[$product["product_info"]["id"], $product["product_info"]["slug"]]) }}">{!! $product["product_info"]["name"] !!}</a>
                                                @if(isset(Session::get("cart")["product_size"]))
                                                    <span>{{ $product["product_size"]["name"] }}</span>
                                                @endif
                                                @if(isset(Session::get("cart")["product_options"]))
                                                    @foreach($product["product_options"] as $option)
                                                        <p>{!! $option["name"] !!}</p>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6>{!! currency($product["product_info"]["price"]) !!}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-primary cart_decrease" style="background: #f86f03"><i class="fal fa-minus"></i></button>
                                                    <input type="text" id="quantity" name="quantity" placeholder="1" readonly value="{{ $product["product_info"]["quantity"] }}">
                                                    <button class="btn btn-primary cart_increase" style="background: #f86f03"><i class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 id="total_price" data-price="{{ $product["product_info"]["price"] }}">
                                                    {{ currency(cartItemTotal($product["product_info"]["id"])) }}
                                                </h6>
                                            </td>

                                            <td class="fp__pro_icon">
                                                <span data-product-id="{{ $product['product_info']['id'] }}" class="delete_cart_item text-center" role="button">
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
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>$124.00</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span>$10.00</span></p>
                        <p class="total"><span>total:</span> <span>$134.00</span></p>
                        <form>
                            <input type="text" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>
                        <a class="common_btn" href=" #">checkout</a>
                    </div>
                </div>
            @else
                <tr>
                    <p class="alert alert-info">Your cart is empty! <a href="{{ route("front.index") }}" class="fw-bolder">Start shopping now.</a></p>
                </tr>
            @endif
        </div>
    </div>
</section>
<!--============================
    CART VIEW END
==============================-->
@endsection
@push("scripts")
    <script>
        /* ////////////////////////////////
                product select
        ////////////////////////////////// */
        $(document).ready(function(){
            let global_quantity = 0

            /* delete item by click */
            $(".delete_cart_item").click(deleteCartItem)

            /* delete all items by click */
            $(".clear_all").click(deleteCartItems)

            /* decrease button */
            $("table button.cart_decrease").click(function(e){
                e.preventDefault()

                const parent = $(this).closest("tr")
                const quantity=parent.find("input[name=quantity]")
                const currentQuantity=parseFloat(quantity.val())

                if(currentQuantity <= 1) return
                
                global_quantity = parseFloat(currentQuantity - 1) || 0
                updateTotalPrice (parent, function () {
                    quantity.val(currentQuantity - 1) 
                })
            })

            /* increase button */
            $("table button.cart_increase").click(function(e){
                e.preventDefault()

                const parent = $(this).closest("tr")
                const quantity=parent.find("input[name=quantity]")
                const currentQuantity=parseFloat(quantity.val())

                if(currentQuantity > 100) return
                
                global_quantity = parseFloat(currentQuantity + 1) || 0
                updateTotalPrice (parent, function () {
                    quantity.val(currentQuantity + 1) 
                })
            })
            
            
            /* ==== functions ==== */

            /* update total price */
            function updateTotalPrice(parent, updateQuantity) {
                const h3= parent.find("#total_price")

                const price= parseFloat(h3.data("price")) || 0
                const qty= global_quantity

                console.log(qty)

                const total=(price * qty).toFixed(2)
                const formatedTotal = total + " {{ $provider_settings->site_currency_icon }}"

                updateCartQuantity(parent, function () {
                    h3.html(formatedTotal)
                    updateQuantity()
                })
            }

            /* update cart item quantity */
            async function updateCartQuantity (parent, updateH3andQuantity) {

                const product_id=parent.data("product-id")
                const qty= global_quantity 
                const formData=new FormData()
                
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("quantity",qty)

                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
                await new Promise(resolve=>setTimeout(resolve,1000))

                await $.ajax({
                    type:"post",
                    contentType:false,
                    processData:false,
                    data: formData,
                    url:"{{ route('front.order.cart.ajax.quantity') }}",
                    success: async function(res){
                        console.log(res)

                        $('.overlay-container').addClass('d-none');
                        $('.overlay').removeClass('active')

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            position: "topRight",
                            color: res.error ? "red" : "green"
                        })                            

                        if(res.success) {
                            await updateCartSidebar()
                            updateH3andQuantity()
                        }
                    }
                })
            }

            /* delete item by click */
            async function deleteCartItem (e) {
                e.preventDefault()
                
                const el=$(this)
                const row=el.closest(".row")
                const tr=el.closest("tr")
                const allTr=el.closest("tbody").find("tr")
                const product_id =el.data("product-id")
                const formData=new FormData()
                
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)

                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                $.ajax({
                    type:"post",
                    contentType:false,
                    processData:false,
                    data: formData,
                    url:"{{ route('front.order.cart.ajax.item.remove') }}",
                    success:async function(res){
                        console.log(res)

                        await tr.slideUp().promise().done(function(){
                            $(this).remove()
                        })

                        $('.overlay-container').addClass('d-none');
                        await $('.overlay').removeClass('active')

                        await updateCartSidebar()

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            position: "topRight",
                            color: res.error ? "red" : "green"
                        })

                        
                        console.log(allTr.length)

                        if(allTr.length <= 2) {
                            row.html('<p class="alert alert-info">Your cart is empty! <a href="{{ route("front.index") }}" class="fw-bolder">Start shopping now.</a></p>') 
                        }
                    }
                })
            }

            /* delete items by click */
            async function deleteCartItems (e) {
                e.preventDefault()
                
                const el=$(this)
                const row=el.closest(".row")
                const tr=el.closest("tr")
                const allTr=el.closest("tbody").find("tr")
                const product_id =el.data("product-id")
                const formData=new FormData()
                

                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                $.ajax({
                    type:"get",
                    contentType:false,
                    processData:false,
                    url:"{{ route('front.order.cart.ajax.items.remove') }}",
                    success:async function(res){
                        console.log(res)

                        $('.overlay-container').addClass('d-none');
                        await $('.overlay').removeClass('active')

                        await updateCartSidebar()

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            position: "topRight",
                            color: res.error ? "red" : "green"
                        })

                        row.html('<p class="alert alert-info">Your cart is empty! <a href="{{ route("front.index") }}" class="fw-bolder">Start shopping now.</a></p>')
                    }
                })
            }

            /* refresh cart sidebar */
            function updateCartSidebar () {
                $.ajax({
                    type:"GET",
                    contentType:false,
                    processData:false,
                    url:"{{ route('front.order.cart.ajax.items') }}",
                    success:function(res){
                        //console.log(res)

                        $(".fp__menu_cart_boody").html(res)  
                        $(".cart_item_count").html($(".cart_item_count_get").html())
                    }
                })
            }
        })
    </script>
@endpush