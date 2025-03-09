@extends("front.layout.app")
@section("title", "Product - ".$product->name)
@section("page_title", "Product Detail")
@section("content")


<!--=============================
    BREADCRUMB START
==============================-->
@include("front.component.bread_crumb")
<!--=============================
    BREADCRUMB END
==============================-->

<!--=============================
    MENU DETAILS START
==============================-->
<section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                <div class="exzoom hidden" id="exzoom">
                    <div class="exzoom_img_box fp__menu_details_images">
                        <ul class='exzoom_img_ul'>
                            <li><img class="zoom img-fluid w-100" src="{{ asset("uploads/product") }}/{{ $product->image }}" alt="product"></li>
                            @foreach($product->product_photos as $product_photo)
                                <li><img class="zoom img-fluid w-100" src="{{ asset("uploads/product-image") }}/{{ $product_photo->image }}" alt="product"></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="exzoom_nav"></div>
                    <p class="exzoom_btn">
                        <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                        </a>
                        <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="fp__menu_details_text">
                    <h2>{{ $product->name }}</h2>
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
                    <p class="short_description">{{ $product->short_description }}</p>

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
                        <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                <div class="fp__menu_description_area mt_100 xs_mt_70">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="menu_det_description">{!! $product->description !!}</div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="fp__review_area">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4>04 reviews</h4>
                                        <div class="fp__comment pt-0 mt_20">
                                            <div class="fp__single_comment m-0 border-0">
                                                <img src="images/comment_img_1.png" alt="review" class="img-fluid">
                                                <div class="fp__single_comm_text">
                                                    <h3>Michel Holder <span>29 oct 2022 </span></h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fad fa-star-half-alt"></i>
                                                        <i class="fal fa-star"></i>
                                                        <b>(120)</b>
                                                    </span>
                                                    <p>Sure there isn't anything embarrassing hiidden in the
                                                        middles of text. All erators on the Internet
                                                        tend to repeat predefined chunks</p>
                                                </div>
                                            </div>
                                            <div class="fp__single_comment">
                                                <img src="images/chef_1.jpg" alt="review" class="img-fluid">
                                                <div class="fp__single_comm_text">
                                                    <h3>salina khan <span>29 oct 2022 </span></h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fad fa-star-half-alt"></i>
                                                        <i class="fal fa-star"></i>
                                                        <b>(120)</b>
                                                    </span>
                                                    <p>Sure there isn't anything embarrassing hiidden in the
                                                        middles of text. All erators on the Internet
                                                        tend to repeat predefined chunks</p>
                                                </div>
                                            </div>
                                            <div class="fp__single_comment">
                                                <img src="images/comment_img_2.png" alt="review" class="img-fluid">
                                                <div class="fp__single_comm_text">
                                                    <h3>Mouna Sthesia <span>29 oct 2022 </span></h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fad fa-star-half-alt"></i>
                                                        <i class="fal fa-star"></i>
                                                        <b>(120)</b>
                                                    </span>
                                                    <p>Sure there isn't anything embarrassing hiidden in the
                                                        middles of text. All erators on the Internet
                                                        tend to repeat predefined chunks</p>
                                                </div>
                                            </div>
                                            <div class="fp__single_comment">
                                                <img src="images/chef_3.jpg" alt="review" class="img-fluid">
                                                <div class="fp__single_comm_text">
                                                    <h3>marjan janifar <span>29 oct 2022 </span></h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fad fa-star-half-alt"></i>
                                                        <i class="fal fa-star"></i>
                                                        <b>(120)</b>
                                                    </span>
                                                    <p>Sure there isn't anything embarrassing hiidden in the
                                                        middles of text. All erators on the Internet
                                                        tend to repeat predefined chunks</p>
                                                </div>
                                            </div>
                                            <a href="#" class="load_more">load More</a>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="fp__post_review">
                                            <h4>write a Review</h4>
                                            <form>
                                                <p class="rating">
                                                    <span>select your rating : </span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </p>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <input type="text" placeholder="Name">
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <input type="email" placeholder="Email">
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <textarea rows="3"
                                                            placeholder="Write your review"></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="common_btn" type="submit">submit
                                                            review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($related_products->count() > 0)
            <div class="fp__related_menu mt_90 xs_mt_60">
                <h2>related item</h2>
                <div class="row related_product_slider">
                    @foreach($related_products as $related_product)
                        <div class="wow fadeInUp" data-wow-duration="1s">
                            <div class="fp__menu_item">
                                <div class="fp__menu_item_img">
                                    <img src="{{ asset("uploads/product") }}/{{ $related_product->image }}" alt="menu" class="img-fluid w-100">
                                    <a class="category" href="#">{!! $related_product->category->name !!}</a>
                                </div>
                                <div class="fp__menu_item_text">
                                    <p class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <span>74</span>
                                    </p>
                                    <a class="title" href="{{ route("front.product",[$related_product->id,$related_product->slug]) }}">{!! $related_product->name !!}</a>
                                    <h5 class="price">
                                        @if($related_product->offer_price > 0)    
                                            {{ currency($related_product->offer_price) }}
                                            <del>{{ currency($related_product->price) }}</del>
                                        @else
                                            {{ currency($related_product->price) }}
                                        @endif
                                    </h5>
                                    <ul class="d-flex flex-wrap justify-content-center">
                                        <li>
                                            <a class="show_up_popup" data-product-id="{{ $related_product->id }}" href="#">
                                                <i class="fas fa-shopping-basket"></i>
                                            </a>
                                        </li>
                                        <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                        <li><a href="#"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
<!--=============================
    MENU DETAILS END
==============================-->
@endsection
@push("scripts")
<script>
    /* ////////////////////////////////
            product select
    ////////////////////////////////// */
    $(document).ready(function(){
        /* size & options */
        $(".fp__menu_details select#product_size").change(function(){
            const parent = $(this).closest(".fp__menu_details")
            updateTotalPrice(parent)
        })
        $(".fp__menu_details select#options").change(function(){
            const parent = $(this).closest(".fp__menu_details")
            updateTotalPrice(parent)
        })

        /* decrease button */
        $(".fp__menu_details button.cart_decrease").click(function(e){
            e.preventDefault()

            const parent = $(this).closest(".fp__menu_details")
            const quantity=parent.find("input[name=quantity]")
            const currentQuantity=parseFloat(quantity.val())

            if(currentQuantity <= 1) return

            quantity.val(currentQuantity - 1)
            updateTotalPrice (parent)
            
        })

        /* increase button */
        $(".fp__menu_details button.cart_increase").click(function(e){
            e.preventDefault()

            const parent = $(this).closest(".fp__menu_details")
            const quantity=parent.find("input[name=quantity]")
            const currentQuantity=parseFloat(quantity.val())

            if(currentQuantity > 100) return
            
            quantity.val(currentQuantity + 1)            
            updateTotalPrice (parent)
        })

        
        /* add to cart */
        $(".fp__menu_details .add_to_cart").click(function(e){
            e.preventDefault()
            
            const el = $(this)
            const parent = el.closest(".fp__menu_details")
            cartSubmit (el,parent)
        })
        
        
        /* ==== functions ==== */


        /* update total price */
        function updateTotalPrice(parent) {

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

        /* cart submit */
        async function cartSubmit(el,parent){

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
            await new Promise(resolve=>setTimeout(resolve,1000))

            $.ajax({
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                url:"{{ route('front.order.cart.ajax.submit') }}",
                success:function(res){
                    console.log(res)

                    if(res.success){
                        el.html('<i class="fa-solid fa-cart-circle-check fs-3"></i>')
                        el.css("pointer-events","none")
                        updateCartSidebar ()
                    }

                    if(res.error)
                        el.html('<span class="text-white">add to cart</span>')


                    iziToast.show({
                        title: res.error?.message ?? res.success?.message,
                        position: "topRight",
                        color: res.error ? "red" : "green"
                    })                   
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
                    console.log(res)

                    $(".fp__menu_cart_boody").html(res)  
                    $(".cart_item_count").html($(".cart_item_count_get").val())
                }
            })
        }
    })
</script>
@endpush