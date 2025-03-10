@extends("front.layout.app")
@section("content")

    <!--=============================
        BANNER START
    ==============================-->
    @if($provider_settings->slider_status == 1 && $slides->count() > 0)
        <section class="fp__banner" style="background: url({{ asset("uploads/setting") }}/{{ $provider_settings->slider_photo }});">
            <div class="fp__banner_overlay">
                <div class="row banner_slider">
                    @foreach($slides as $slide)
                        <div class="col-12">
                            <div class="fp__banner_slider">
                                <div class=" container">
                                    <div class="row">
                                        <div class="col-xl-5 col-md-5 col-lg-5">
                                            <div class="fp__banner_img wow fadeInLeft" data-wow-duration="1s">
                                                <div class="img">
                                                    <img src="{{ asset("uploads/slider") }}/{{ $slide->image }}" alt="food item" class="img-fluid w-100">
                                                    <span> {{ $slide->offer }} </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-md-7 col-lg-6">
                                            <div class="fp__banner_text wow fadeInRight" data-wow-duration="1s">
                                                <h1>{{ $slide->title }}</h1>
                                                <h3>{{ $slide->sub_title }}</h3>
                                                <p>{{ $slide->short_description }}</p>
                                                @if(!empty($slide->button_link))
                                                    <ul class="d-flex flex-wrap">
                                                        <li><a class="common_btn" href="{{ $slide->button_link }}">shop now</a></li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--=============================
        BANNER END
    ==============================-->


    <!--=============================
        CHOOSE START
    ==============================-->
    @if($provider_settings->why_choose_status == 1 && $whyChooses->count() > 0)
        @include("front.component.choose")
    @endif
    <!--=============================
        CHOOSE END
    ==============================-->


    <!--=============================
        OFFER ITEM START
    ==============================-->
    <section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="fp__section_heading mb_50">
                        <h4>daily offer</h4>
                        <h2>up to 75% off for this day</h2>
                        <span>
                            <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional materials.</p>
                    </div>
                </div>
            </div>

            <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
                <div class="">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="images/slider_img_1.png" alt="offer" class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <span>30% off</span>
                            <a class="title" href="menu_details.html">Dal Makhani Paneer</a>
                            <p>Lightly smoked and minced pork tenderloin topped</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cartModal"><i
                                            class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="images/slider_img_2.png" alt="offer" class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <span>40% off</span>
                            <a class="title" href="menu_details.html">Hyderabadi biryani</a>
                            <p>Lightly smoked and minced pork tenderloin topped</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#" data-toggle="modal" data-target="#cartModal"><i class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="images/slider_img_3.png" alt="offer" class="img-fluid w-100">
                        </div>
                        <div class="text">

                            <span>55% off</span>
                            <a class="title" href="menu_details.html">Beef Masala Salad</a>
                            <p>Lightly smoked and minced pork tenderloin topped</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cartModal"><i
                                            class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="images/slider_img_2.png" alt="offer" class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <span>45% off</span>
                            <a class="title" href="menu_details.html">Indian cuisine Pakora</a>
                            <p>Lightly smoked and minced pork tenderloin topped</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cartModal"><i
                                            class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        OFFER ITEM END
    ==============================-->


    <!--=============================
        MENU ITEM START
    ==============================-->
    @if($provider_settings->menu_status == 1)
        <section class="fp__menu mt_95 xs_mt_65">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                        <div class="fp__section_heading mb_45">
                            <h4>{!! $provider_settings->menu_title !!}</h4>
                            <h2>{!! $provider_settings->menu_sub_title !!}</h2>
                            <span>
                                <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                            </span>
                            <p>{!! $provider_settings->menu_description !!}</p>
                        </div>
                    </div>
                </div>

                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-12">
                        <div class="menu_filter d-flex flex-wrap justify-content-center">
                            <button class=" active" data-filter="*">all menu</button>
                            @foreach($categories as $category)
                                <button data-filter=".{{ $category->slug }}">{{ $category->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row grid">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-sm-6 col-lg-4 {{ $product->category->slug }} wow fadeInUp" data-wow-duration="1s">
                            <div class="fp__menu_item">
                                <div class="fp__menu_item_img">
                                    <img src="{{ asset("uploads/product") }}/{{ $product->image }}" alt="menu" class="img-fluid w-100">
                                    <a class="category" href="#">{{ $product->category->name }}</a>
                                </div>
                                <div class="fp__menu_item_text">
                                    <p class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <span>10</span>
                                    </p>
                                    <a class="title" href="{{ route("front.product",[$product->id,$product->slug]) }}">{{ $product->name }}</a>
                                    <h3 class="price">
                                        @if($product->offer_price > 0)    
                                            {{ currency($product->offer_price) }}
                                            <del>{{ currency($product->price) }}</del>
                                        @else
                                            {{ currency($product->price) }}
                                        @endif
                                    </h3>
                                    <ul class="d-flex flex-wrap justify-content-center">
                                        <li>
                                            <a class="show_up_popup" data-product-id="{{ $product->id }}" href="#">
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
        </section>
    @endif
    <!--=============================
        MENU ITEM END
    ==============================-->


    <!--=============================
        ADD SLIDER START
    ==============================-->
    <section class="fp__add_slider mt_100 xs_mt_70 pt_100 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row add_slider wow fadeInUp" data-wow-duration="1s">
                <div class="col-xl-4">
                    <a href="#" class="fp__add_slider_single" style="background: url(images/offer_slider_3.png);">
                        <div class="text">
                            <h3>red chicken</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="#" class="fp__add_slider_single" style="background: url(images/offer_slider_2.png);">
                        <div class="text">
                            <h3>red chicken</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="#" class="fp__add_slider_single" style="background: url(images/offer_slider_1.png);">
                        <div class="text">
                            <h3>red chicken</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4">
                    <a href="#" class="fp__add_slider_single" style="background: url(images/offer_slider_4.png);">
                        <div class="text">
                            <h3>red chicken</h3>
                            <p>Lorem ipsum dolor sit amet consectetur.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        ADD SLIDER END
    ==============================-->


    <!--=============================
        TEAM START
    ==============================--> 
    @include("front.component.team")
    <!--=============================
        TEAM END
    ==============================-->


    <!--=============================
        DOWNLOAD APP START
    ==============================-->
    <section class="fp__download mt_100 xs_mt_70">
        <div class="fp__download_bg" style="background: url(images/download_bg.jpg);">
            <div class="fp__download_overlay">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-5 col-md-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="fp__download_img">
                                <img src="images/download_img.png" alt="download" class="img-fluid w-100">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 wow fadeInUp" data-wow-duration="1s">
                            <div class="fp__download_text">
                                <div class="fp__section_heading mb_25">
                                    <h2>download our mobile apps</h2>
                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda
                                        tenetur,
                                        provident earum consequatur, ut voluptas laboriosam fuga error aut eaque
                                        architecto
                                        quo pariatur. Vel dolore omnis quisquam. Lorem ipsum dolor, sit amet consectetur
                                        adipisicing elit Cumque.</p>
                                </div>
                                <ul class="d-flex flex-wrap">
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-google-play"></i>
                                            <p> <span>download from</span> google play </p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fab fa-apple"></i>
                                            <p> <span>download from</span> apple store </p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        DOWNLOAD APP END
    ==============================-->


    <!--=============================
        TESTIMONIAL START
    ==============================--> 
    @include("front.component.testimonial")
    <!--=============================
        TESTIMONIAL END
    ==============================--> 


    <!--=============================
        COUNTER START
    ==============================-->
    @include("front.component.counter")
    <!--=============================
        COUNTER END
    ==============================-->


    <!--=============================
        BLOG 2 START
    ==============================-->
    <section class="fp__blog fp__blog2">
        <div class="fp__blog_overlay pt_95 pt_xs_60 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                        <div class="fp__section_heading mb_25">
                            <h4>news & blogs</h4>
                            <h2>our latest foods blog</h2>
                            <span>
                                <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_blog">
                            <a href="#" class="fp__single_blog_img">
                                <img src="images/menu2_img_1.jpg" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="fp__single_blog_text">
                                <a class="category" href="#">chicken</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 25 oct 2022</li>
                                    <li><i class="fas fa-comments"></i> 25 comment</li>
                                </ul>
                                <a class="title" href="blog_details.html">Competently supply customized initiatives</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_blog">
                            <a href="#" class="fp__single_blog_img">
                                <img src="images/menu2_img_2.jpg" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="fp__single_blog_text">
                                <a class="category" href="#">kabab</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 27 oct 2022</li>
                                    <li><i class="fas fa-comments"></i> 41 comment</li>
                                </ul>
                                <a class="title" href="blog_details.html">Unicode UTF8 Character Sets They Sltimate
                                    Guide Systems</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_blog">
                            <a href="#" class="fp__single_blog_img">
                                <img src="images/menu2_img_3.jpg" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="fp__single_blog_text">
                                <a class="category" href="#">grill</a>
                                <ul class="d-flex flex-wrap mt_15">
                                    <li><i class="fas fa-user"></i>admin</li>
                                    <li><i class="fas fa-calendar-alt"></i> 27 oct 2022</li>
                                    <li><i class="fas fa-comments"></i> 32 comment</li>
                                </ul>
                                <a class="title" href="blog_details.html">Quality Foods Requirments For Every Human
                                    Body’s</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BLOG 2 END
    ==============================-->
@endsection