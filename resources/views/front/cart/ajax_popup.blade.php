<!-- CART POPUT START -->
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></button>
<div class="fp__cart_popup_img">
    <img src="{{ asset("uploads/product") }}/{{ $product->image }}" alt="menu" class="img-fluid w-100">
</div>
<div class="fp__cart_popup_text">
    <a href="{{ route("front.product",[$product->id,$product->slug]) }}" class="title">{{ $product->name }}</a>
    <p class="rating">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star-half-alt"></i>
        <i class="far fa-star"></i>
        <span>(201)</span>
    </p>
    <h3 class="price">
        @if($product->offer_price > 0)    
            {{ currency($product->offer_price) }}
            <del>{{ currency($product->price) }}</del>
        @else
            {{ currency($product->price) }}
        @endif
    </h3>

    @if($product->product_sizes->count() > 0)
        <div class="details_size">
            <div class="form-group">
                <label for="product_size" class="fs-5 mb-1 fw-bold">Select Size</label>
                <select id="product_size" name="product_size" class="form-control">
                    <option selected>Normal</option>
                    @foreach($product->product_sizes as $product_size)
                        <option 
                            value="{{ $product_size->id }}" data-price="{{ $product_size->price }}" 
                            @if(isset(Session::get("cart")["cart"][$product->id]["product_size"]) && Session::get("cart")["cart"][$product->id]["product_size"]["id"] ==  $product_size->id) 
                                selected
                            @endif
                        >
                            {{ $product_size->name }} (+{{ currency($product_size->price) }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    @if($options->count() > 0)
        <div class="details_extra_item">
            <div class="form-group">
                <label for="options" class="fs-5 mb-1 fw-bold">Select Options</label>
                <select id="options" name="options[]" class="form-control select2" multiple>
                    @foreach($options as $option)
                        <option 
                            value="{{ $option->id }}" data-price="{{ $option->price }}"
                            @if(isset(Session::get("cart")["cart"][$product->id]["product_options"]) && 
                            in_array($option->id, array_column(Session::get("cart")["cart"][$product->id]["product_options"], "id"))) 
                                selected
                            @endif
                        >
                            <strong>{{ $option->name }}</strong>  (+{{ currency($option->price) }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div class="details_quentity">
        <h5>select quentity</h5>
        <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
            <div class="quentity_btn">
                <button class="btn btn-primary cart_decrease" style="background: #f86f03"><i class="fal fa-minus"></i></button>
                <input 
                    type="text" id="quantity" name="quantity" placeholder="1" readonly
                    @if(isset(Session::get("cart")["cart"][$product->id]["product_info"])) 
                        value="{{ Session::get("cart")["cart"][$product->id]["product_info"]["quantity"] }}" 
                    @else
                        value="1" 
                    @endif
                >
                <button class="btn btn-primary cart_increase" style="background: #f86f03"><i class="fal fa-plus"></i></button>
            </div>
            <h3 
                id="total_price" 
                data-price="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}"
            >
                @if(isset(Session::get("cart")["cart"][$product->id]["product_info"]))
                    {{ currency(cartItemSubTotal($product->id)) }}
                @else
                    @if ($product->offer_price > 0)
                        {{ currency($product->offer_price) }}
                    @else
                        {{ currency($product->price) }}
                    @endif
                @endif
            </h3>
        </div>
    </div>
    <ul class="details_button_area d-flex flex-wrap">
        <li>
            @if($product->max_quantity === 0)
                <a class="common_btn bg-danger" href="javascript:void(0)">Stock out</a>
            @elseif(Session::has("cart") && array_key_exists($product->id, Session::get("cart")["cart"]))
                <a class="common_btn" href="javascript:void(0)">
                    <i class="fa-solid fa-cart-circle-check fs-3"></i>
                </a>
            @else
                <a data-product-id="{{ $product->id }}" class="common_btn add_to_cart" href="javascript:void(0)">
                    <span class="text-white">add to cart</span>
                </a>
            @endif
        </li>
    </ul>
</div>
<!-- CART POPUT END -->


<script>
    /* ////////////////////////////////
            PRODUCT SELECT & STORE
    ////////////////////////////////// */
    $(document).ready(function(){
        /* size & options */
        $(".fp__cart_popup_text select#product_size").change(function(){
            const parent = $(this).closest(".fp__cart_popup_text")
            handlerUpdateTotalPrice(parent)
        })
        $(".fp__cart_popup_text select#options").change(function(){
            const parent = $(this).closest(".fp__cart_popup_text")
            handlerUpdateTotalPrice(parent)
        })

        /* decrease button */
        $(".fp__cart_popup_text button.cart_decrease").click(function(e){
            e.preventDefault()

            const parent = $(this).closest(".fp__cart_popup_text")
            const quantity=parent.find("input[name=quantity]")
            const currentQuantity=parseFloat(quantity.val())

            if(currentQuantity <= 1) return

            quantity.val(currentQuantity - 1)
            handlerUpdateTotalPrice (parent)
            
        })

        /* increase button */
        $(".fp__cart_popup_text button.cart_increase").click(function(e){
            e.preventDefault()

            const parent = $(this).closest(".fp__cart_popup_text")
            const quantity=parent.find("input[name=quantity]")
            const currentQuantity=parseFloat(quantity.val())

            if(currentQuantity > 100) return
            
            quantity.val(currentQuantity + 1)            
            handlerUpdateTotalPrice (parent)
        })
        $(".fp__cart_popup_text .add_to_cart").click(handlerCartSubmit)


        /* update total price */
        function handlerUpdateTotalPrice(parent) {
            const quantity=parent.find("input[name=quantity]")

            const h3= parent.find("#total_price")
            const product_size=  parent.find("select#product_size option:selected")
            const options=  parent.find("select#options option:selected")

            const pasePrice= parseFloat(h3.data("price")) || 0
            const sizePrice= parseFloat(product_size.data("price")) || 0
            let optionPrice=0
            const qty= parseFloat(quantity.val()) || 0

            if(options && options.length > 0)
                options.each(function(){
                    optionPrice += parseFloat($(this).data("price")) || 0
                })

            const total=((pasePrice + sizePrice + optionPrice) * qty).toFixed(2)
            const formatedTotal = total + " {{ $provider_settings->site_currency_icon }}"
            
            h3.html(formatedTotal)
        }

        async function handlerCartSubmit(e){
            e.preventDefault()
            
            const el = $(this)
            const parent = $(this).closest(".fp__cart_popup_text")
            const quantity=parent.find("input[name=quantity]")
            const product_id=el.data("product-id")
            const product_size=parent.find("select#product_size").val()
            const options=parent.find("select#options").val()
            const formData=new FormData()

            formData.append("_token", "{{ csrf_token() }}")
            formData.append("product_id",product_id)
            
            if(options && options.length > 0)
                options.forEach(option=>{
                    formData.append("options[]",option)
                })

            if(Number(product_size)) formData.append("product_size",product_size)
            formData.append("quantity",quantity.val())

            el.html('<div class="spinner-border" role="status"></div>')

            const store = await storeCartItem(formData)

            if(store.success){
                el.html('<i class="fa-solid fa-cart-circle-check fs-3"></i>')
                el.css("pointer-events","none")
                fetchCartSidebar()
                fetchCartCount()
            }

            if(store.error)
                el.html('<span class="text-white">add to cart</span>')

            showNotification(store)
        }

        async function storeCartItem(formData){
            let result
            await delay(1000)
            await $.ajax({
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                url:"{{ route('front.order.cart.ajax.submit') }}",
                success:function(res){
                    result=res
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
            return result
        }

        function fetchCartSidebar(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.cart.ajax.items') }}",
                success:function(res){
                    $("[data-section-cart=sidebar-items]").html(res)
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }

        function fetchCartCount(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.cart.ajax.count') }}",
                success:function(count){
                    $("[data-section-cart=count]").html(count) 
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
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

        function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    })
</script>
