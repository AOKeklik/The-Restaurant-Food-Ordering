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
        <div data-section-cart="page" class="row wow fadeInUp" data-wow-duration="1s">
            @include("front.cart.ajax_page")
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
                    CART PAGE
        ////////////////////////////////// */
        $(document).ready(function(){
            let global_quantity = 0

            $(document)
                /* delete item by click - delete all items by click */
                .on("click",".delete_cart_item",handlerDeleteCartItem)
                .on("click",".clear_all",handlerDeleteCartItems)

                /* apply coupon by click - delete coupon by click */
                .on("click","#coupon_apply",handlerUpdateCartCoupon)
                .on("click","#add_coupon_html",handleDeleteCartCoupon)

                /* decrease button - increase button */
                .on("click","table button.cart_decrease",handlerDecreaseQuantity)
                .on("click","table button.cart_increase",handlerIncreaseQuantity)

            function handlerDeleteCartItem (e) {
                e.preventDefault()
                
                const el=$(this)
                const product_id =el.data("product-id")
                const formData=new FormData()
                
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)

                executeAjax(
                    "{{ route('front.order.cart.ajax.item.remove') }}",
                    formData,
                    res => {
                        fetchCartSidebar()
                        fetchCartPage()
                        fetchCartCount()
                    }
                )
            }

            function handlerDeleteCartItems (e) {
                e.preventDefault()

                executeAjax(
                    "{{ route('front.order.cart.ajax.items.remove') }}",
                    null,
                    res => {
                        fetchCartSidebar()
                        fetchCartPage()
                        fetchCartCount()
                    }
                )
            }

            function handlerUpdateCartCoupon (e) {
                e.preventDefault()

                const parent=$(this).closest("form")
                const code=parent.find("[name=code]").val()
                const formData=new FormData()

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("code",code)

                executeAjax(
                    "{{ route('front.order.coupon.ajax.submit') }}",
                    formData,
                    res => {
                        if(res.success) {
                            fetchCartSidebar()
                            fetchCartPage()
                        }
                    }
                )
            }

            async function handleDeleteCartCoupon (e) {
                e.preventDefault()
                
                if(!e.target.closest("button")) return

                await executeAjax(
                    "{{ route('front.order.coupon.ajax.remove') }}",
                    null,
                    res => {
                        if(res.success) {
                            fetchCartSidebar()
                            fetchCartPage()
                        }
                    }
                )
            }

            function handlerDecreaseQuantity(e){
                e.preventDefault()

                const parent = $(this).closest("tr")
                const quantity=parent.find("input[name=quantity]")
                const currentQuantity=parseFloat(quantity.val())

                if(currentQuantity <= 1) return

                global_quantity = parseFloat(currentQuantity - 1) || 0
                updateCartQuantity(parent)
            }

            function handlerIncreaseQuantity(e){
                e.preventDefault()

                const parent = $(this).closest("tr")
                const quantity=parent.find("input[name=quantity]")
                const currentQuantity=parseFloat(quantity.val())

                if(currentQuantity > 100) return
                
                global_quantity = parseFloat(currentQuantity + 1) || 0
                updateCartQuantity(parent, () => {
                    fetchCartSidebar()
                    fetchCartPage()
                    fetchCartCount()
                })
            }

            function updateCartQuantity (parent) {

                const product_id=parent.data("product-id")
                const formData=new FormData()

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("quantity",global_quantity)

                executeAjax(
                    "{{ route('front.order.cart.ajax.quantity') }}",
                    formData,
                    res => {
                        fetchCartPage()
                        fetchCartCount()
                        fetchCartSidebar()
                    }
                )
            }

            function fetchCartSidebar(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('front.order.cart.ajax.items') }}",
                    success:function(cartItems){
                        $("[data-section-cart=sidebar-items]").html(cartItems)
                    }
                })
            }

            function fetchCartPage() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('front.order.cart.ajax.page') }}",
                    success: function(cartPage) {
                        $("[data-section-cart=page]").html(cartPage) 
                    }
                })
            }

            function fetchCartCount(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('front.order.cart.ajax.count') }}",
                    success:function(count){
                        $("[data-section-cart=count]").html(count) 
                    }
                })
            }

            async function executeAjax(url,formData=null,callback=()=>{}){
                showOverlay()
                await delay(1000)
                
                $.ajax({
                    type: formData ? "post" : "get",
                    contentType: false,
                    processData: false,
                    data:formData,
                    url,
                    success:async function(res){
                        console.log(res)

                        hideOverlay()
                        showNotification(res)

                        callback(res)
                    }
                })
            }

            function showNotification(res){
                iziToast.show({
                    title: res.error?.message ?? res.success?.message,
                    position: "topRight",
                    color: res.error ? "red" : "green"
                })
            }

            function showOverlay(){
                $('.overlay-container').removeClass('d-none')
                $('.overlay').addClass('active')
            }

            function hideOverlay(){
                $('.overlay-container').addClass('d-none');
                $('.overlay').removeClass('active')
            }

            function delay(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            function createCouponHtml(code){
                return `
                    <div class="card mt-4 mb-2">
                        <div class="m-2">
                            <span><b>${code}</b></span>
                            <span>
                                <button><i class="far fa-times"></i></button>
                            </span>
                        </div>
                    </div>
                `
            }
        })
    </script>
@endpush


