@extends("front.layout.app")
@section("title", "Payment Method")
@section("page_title", "Payment Method")
@section("content")

<!--=============================
    BREADCRUMB START
==============================-->
@include("front.component.bread_crumb")
<!--=============================
    BREADCRUMB END
==============================-->

<!--============================
    PAYMENT PAGE START
==============================-->
<section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="fp__payment_area">
                    <div class="row">
                        <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                            <a class="fp__single_payment" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                <img src="images/pay_1.jpg" alt="payment method" class="img-fluid w-100">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- cart --}}
            @include("front.component.cart")
        </div>
    </div>
</section>

<div class="fp__payment_modal">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fp__pay_modal_info">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, tempora cum optio
                            cumque rerum dolor impedit exercitationem? Eveniet suscipit repellat, quae natus hic
                            assumenda.</p>
                        <ul>
                            <li>Natus hic assumenda consequatur excepturi ducimu.</li>
                            <li>Cumque rerum dolor impedit exercitationem Eveniet.</li>
                            <li>Dolor sit amet consectetur adipisicing elit tempora cum </li>
                        </ul>
                        <form>
                            <input type="text" placeholder="Enteer Something">
                            <textarea rows="4" placeholder="Enter Something"></textarea>
                            <select id="select_js3">
                                <option value="">select country</option>
                                <option value="">bangladesh</option>
                                <option value="">nepal</option>
                                <option value="">japan</option>
                                <option value="">korea</option>
                                <option value="">thailand</option>
                            </select>
                            <div class="fp__payment_btn_area">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============================
    PAYMENT PAGE END
==============================-->
@endsection