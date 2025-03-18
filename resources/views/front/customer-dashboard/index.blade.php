@extends("front.layout.app")
@section("title","Dashboard")
@section("content")
     <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url();">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>user dashboard</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=========================
        DASHBOARD START
    ==========================-->
    <section class="fp__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="fp__dashboard_area">
                <div class="row">
                    @include("front.component.customer_navbar")
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_content">
                            <div class="tab-content" id="v-pills-tabContent">

                                {{-- profile --}}
                                @include("front.customer-dashboard.profile")
                                
                                {{-- address --}}
                                @include("front.customer-dashboard.address")

                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="fp_dashboard_body">
                                        <h3>order list</h3>
                                        <div class="fp_dashboard_order">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr class="t_header">
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#2545758745</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 16, 2022</p>
                                                            </td>
                                                            <td>
                                                                <span class="complete">Complated</span>
                                                            </td>
                                                            <td>
                                                                <h5>$560</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#2457945235</h5>
                                                            </td>
                                                            <td>
                                                                <p>jan 21, 2021</p>
                                                            </td>
                                                            <td>
                                                                <span class="complete">complete</span>
                                                            </td>
                                                            <td>
                                                                <h5>$654</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#2456875648</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 11, 2020</p>
                                                            </td>
                                                            <td>
                                                                <span class="active">active</span>
                                                            </td>
                                                            <td>
                                                                <h5>$440</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#7896542130</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 16, 2022</p>
                                                            </td>
                                                            <td>
                                                                <span class="active">active</span>
                                                            </td>
                                                            <td>
                                                                <h5>$225</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#4587964125</h5>
                                                            </td>
                                                            <td>
                                                                <p>jan 21, 2021</p>
                                                            </td>
                                                            <td>
                                                                <span class="cancel">cancel</span>
                                                            </td>
                                                            <td>
                                                                <h5>$335</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#4579654153</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 11, 2020</p>
                                                            </td>
                                                            <td>
                                                                <span class="cancel">cancel</span>
                                                            </td>
                                                            <td>
                                                                <h5>$550</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#12547965423</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 16, 2022</p>
                                                            </td>
                                                            <td>
                                                                <span class="complete">Complated</span>
                                                            </td>
                                                            <td>
                                                                <h5>$545</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#4589635878</h5>
                                                            </td>
                                                            <td>
                                                                <p>jan 21, 2021</p>
                                                            </td>
                                                            <td>
                                                                <span class="cancel">cancel</span>
                                                            </td>
                                                            <td>
                                                                <h5>$600</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5>#89698745895</h5>
                                                            </td>
                                                            <td>
                                                                <p>July 11, 2020</p>
                                                            </td>
                                                            <td>
                                                                <span class="complete">complete</span>
                                                            </td>
                                                            <td>
                                                                <h5>$200</h5>
                                                            </td>
                                                            <td><a class="view_invoice">View Details</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="fp__invoice">
                                            <a class="go_back"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
                                            <div class="fp__track_order">
                                                <ul>
                                                    <li class="active">order pending</li>
                                                    <li>order accept</li>
                                                    <li>order process</li>
                                                    <li>on the way</li>
                                                    <li>Completed</li>
                                                </ul>
                                            </div>
                                            <div class="fp__invoice_header">
                                                <div class="header_address">
                                                    <h4>invoice to</h4>
                                                    <p>7232 Broadway Suite 308, Jackson Heights, 11372, NY, United
                                                        States</p>
                                                    <p>+1347-430-9510</p>
                                                </div>
                                                <div class="header_address">
                                                    <p><b>invoice no: </b><span>4574</span></p>
                                                    <p><b>Order ID:</b> <span> #4789546458</span></p>
                                                    <p><b>date:</b> <span>10-11-2022</span></p>
                                                </div>
                                            </div>
                                            <div class="fp__invoice_body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr class="border_none">
                                                                <th class="sl_no">SL</th>
                                                                <th class="package">item description</th>
                                                                <th class="price">Price</th>
                                                                <th class="qnty">Quantity</th>
                                                                <th class="total">Total</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">01</td>
                                                                <td class="package">
                                                                    <p>Hyderabadi Biryani</p>
                                                                    <span class="size">small</span>
                                                                    <span class="coca_cola">coca-cola</span>
                                                                    <span class="coca_cola2">7up</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">02</td>
                                                                <td class="package">
                                                                    <p>Daria Shevtsova</p>
                                                                    <span class="size">medium</span>
                                                                    <span class="coca_cola">coca-cola</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">03</td>
                                                                <td class="package">
                                                                    <p>Hyderabadi Biryani</p>
                                                                    <span class="size">large</span>
                                                                    <span class="coca_cola2">7up</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">04</td>
                                                                <td class="package">
                                                                    <p>Hyderabadi Biryani</p>
                                                                    <span class="size">medium</span>
                                                                    <span class="coca_cola">coca-cola</span>
                                                                    <span class="coca_cola2">7up</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">05</td>
                                                                <td class="package">
                                                                    <p>Daria Shevtsova</p>
                                                                    <span class="size">large</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">04</td>
                                                                <td class="package">
                                                                    <p>Hyderabadi Biryani</p>
                                                                    <span class="size">medium</span>
                                                                    <span class="coca_cola">coca-cola</span>
                                                                    <span class="coca_cola2">7up</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="sl_no">04</td>
                                                                <td class="package">
                                                                    <p>Hyderabadi Biryani</p>
                                                                    <span class="size">medium</span>
                                                                    <span class="coca_cola">coca-cola</span>
                                                                    <span class="coca_cola2">7up</span>
                                                                </td>
                                                                <td class="price">
                                                                    <b>$120</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>2</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$240</b>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="package" colspan="3">
                                                                    <b>sub total</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b>12</b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$755</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="package coupon" colspan="3">
                                                                    <b>(-) Discount coupon</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b></b>
                                                                </td>
                                                                <td class="total coupon">
                                                                    <b>$0.00</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="package coast" colspan="3">
                                                                    <b>(+) Shipping Cost</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b></b>
                                                                </td>
                                                                <td class="total coast">
                                                                    <b>$10.00</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="package" colspan="3">
                                                                    <b>Total Paid</b>
                                                                </td>
                                                                <td class="qnty">
                                                                    <b></b>
                                                                </td>
                                                                <td class="total">
                                                                    <b>$765</b>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <a class="print_btn common_btn" href="#"><i class="far fa-print"></i> print
                                                PDF</a>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="v-pills-messages2" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab2">
                                    <div class="fp_dashboard_body">
                                        <h3>wishlist</h3>
                                        <div class="fp__dashoard_wishlist">

                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_1.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">Biryani</a>
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
                                                            <a class="title" href="menu_details.html">Hyderabadi
                                                                biryani</a>
                                                            <h5 class="price">$70.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_2.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>145</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_3.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">grill</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>54</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">daria
                                                                shevtsova</a>
                                                            <h5 class="price">$99.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_4.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
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
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_5.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>120</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_6.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">Biryani</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>514</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">Hyderabadi
                                                                biryani</a>
                                                            <h5 class="price">$70.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="fp__pagination mt_35">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <nav aria-label="...">
                                                            <ul class="pagination justify-content-start">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#"><i
                                                                            class="fas fa-long-arrow-alt-left"></i></a>
                                                                </li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="#">1</a></li>
                                                                <li class="page-item active"><a class="page-link"
                                                                        href="#">2</a></li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="#">3</a></li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#"><i
                                                                            class="fas fa-long-arrow-alt-right"></i></a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="fp_dashboard_body dashboard_review">
                                        <h3>review</h3>
                                        <div class="fp__review_area">
                                            <div class="fp__comment pt-0 mt_20">
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="images/menu1.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">mamun ahmed shuvo</a> <span>29 oct 2022 </span>
                                                        </h3>
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
                                                        <span class="status active">active</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu2.png" alt=" review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">asaduzzaman khan</a> <span>29 oct 2022 </span>
                                                        </h3>
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
                                                        <span class="status inactive">inactive</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu3.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">ariful islam rupom</a> <span>29 oct 2022 </span>
                                                        </h3>
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
                                                        <span class="status active">active</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu4.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">ali ahmed jakir</a> <span>29 oct 2022 </span>
                                                        </h3>
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
                                                        <span class="status inactive">inactive</span>
                                                    </div>
                                                </div>
                                                <a href="#" class="load_more">load More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- password --}}
                                @include("front.customer-dashboard.password")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        DASHBOARD END 
    ==========================-->
@endsection
@push("scripts")
<script>
    /* ////////////////////////////////////
                ADDRESS EDIT FORM
    /////////////////////////////////////// */
    $(document).ready(function(){
        const delayTime = 1000
        
        $(document)
            /* profile */
            .on("click","[data-btn=profile-edit]",handlerShowProfileUpdateForm)
            .on("click","[data-btn=profile-update]",handlerUpdateProfile)
            /* address */
            .on("click","[data-btn=address-edit]",handlerShowAddressUpdateForm)
            .on("click","[data-btn=address-cancel]",handlerHideAddressForms)
            .on("click","[data-btn=address-store]",handlerStoreAddress)
            .on("click","[data-btn=address-update]",handlerUpdateAddress)
            .on("click","[data-btn=address-delete]",handlerDeleteAddress)
        
        /* PROFILE */
        function handlerShowProfileUpdateForm(e){
            e.preventDefault()

            if($(e.target).hasClass("edit"))
                $(".fp_dash_personal_info").addClass("show")

            if($(e.target).hasClass("cancel"))
                hideProfileUpdateForm()

        }

        async function handlerUpdateProfile(e){
            e.preventDefault()

            const formData=new FormData()
            const form = $("[data-form=profile-update]")

            formData.append("_token","{{ csrf_token() }}")
            formData.append("name",form.find("#name").val())
            formData.append("email",form.find("#email").val())

            showOverlay()

            const updateProfile = await executeAjax(
                "{{ route('front.customer.profile.update.ajax') }}",
                formData
            )

            if(updateProfile.error) {
                $("[data-alert^=profile-update]").html("")
                hideOverlay()
                Object.keys(updateProfile.error.message).forEach(key => {
                    const message = updateProfile.error.message[key][0]
                    $("[data-alert=profile-update-"+key+"]").html(message)
                })

                return
            }

            const fetchProfileForm = await executeAjax(
                "{{ route('front.customer.profile.edit.ajax') }}",
                null
            )
            
            const fetchProfileInfo = await executeAjax(
                "{{ route('front.customer.profile.info.ajax') }}",
                null
            )

            resetForm(form)
            hideOverlay()
            showNotification(updateProfile)
            $("[data-section=profile-edit]").html(fetchProfileForm)
            $("[data-section=profile-info]").html(fetchProfileInfo)
            $(".dasboard_header h2").html($("[data-section=profile-info] span.name").html())
            hideProfileUpdateForm()
        }

        /*  ADDRESS */
        async function handlerShowAddressUpdateForm (e){
            e.preventDefault()

            const formData=new FormData()
            formData.append("_token","{{ csrf_token() }}")
            formData.append("address_id",$(this).data("address-id"))
            
            showOverlay()

            const res = await executeAjax(
                "{{ route('front.customer.address.edit.ajax') }}",
                formData
            )

            hideOverlay()
            $("[data-section=address-edit-form]").html(res)
            if(res.error) showNotification(res)
            $('.niceselect2').niceSelect('destroy').niceSelect();
            showAddressUpdateForm()
        }

        function handlerHideAddressForms(e){
            e.preventDefault()
            hideAddressUpdateForm()
            hideAddressStoreForm()
        }

        async function handlerStoreAddress(e){
            e.preventDefault()

            const formData=new FormData()
            const form = $("[data-form=address-store]")

            formData.append("_token","{{ csrf_token() }}")
            formData.append("user_id",form.find("#user_id").val())
            formData.append("first_name",form.find("#first_name").val())
            formData.append("last_name",form.find("#last_name").val())
            formData.append("phone",form.find("#phone").val())
            formData.append("email",form.find("#email").val())
            formData.append("delivery_area_id",form.find("#delivery_area_id").val())
            formData.append("address",form.find("#address").val())
            formData.append("type",form.find("input.type:checked").val())

            const store = await storeAddressItem(formData)

            if(store.error_form) {
                hideOverlay()
                $("[data-alert^=address-store]").html("")
                Object.keys(store.error_form.message).forEach(key => {
                    const message = store.error_form.message[key][0]
                    $("[data-alert=address-store-"+key+"]").html(message)
                })

                return
            }

            const fetch = await executeAjax(
                "{{ route('front.customer.address.items.ajax') }}",
                null
            )

            hideOverlay()
            resetForm(form)
            showNotification(store)
            $("[data-section=address-items]").html(fetch)
            hideAddressStoreForm()
        }

        async function handlerUpdateAddress(e){
            e.preventDefault()

            const formData=new FormData()
            const form = $("[data-form=address-update]")

            formData.append("_token","{{ csrf_token() }}")
            formData.append("address_id",form.find("#address_id").val())
            formData.append("user_id",form.find("#user_id").val())
            formData.append("first_name",form.find("#first_name").val())
            formData.append("last_name",form.find("#last_name").val())
            formData.append("phone",form.find("#phone").val())
            formData.append("email",form.find("#email").val())
            formData.append("delivery_area_id",form.find("#delivery_area_id").val())
            formData.append("address",form.find("#address").val())
            formData.append("type",form.find("input.type:checked").val())

            showOverlay()

            const updateItem = await executeAjax(
                "{{ route('front.customer.address.update.ajax') }}",
                formData
            )

            if(updateItem.error) {
                $("[data-alert^=address-update]").html("")
                hideOverlay()
                Object.keys(updateItem.error.message).forEach(key => {
                    const message = updateItem.error.message[key][0]
                    $("[data-alert=address-update-"+key+"]").html(message)
                })

                return
            }
            
            const fetchItems = await executeAjax(
                "{{ route('front.customer.address.items.ajax') }}",
                null
            )

            resetForm(form)
            hideOverlay()
            showNotification(updateItem)
            $("[data-section=address-items]").html(fetchItems)
            hideAddressUpdateForm()
        }

        async function handlerDeleteAddress(e){
            e.preventDefault()

            const formData=new FormData()

            formData.append("_token","{{ csrf_token() }}")
            formData.append("address_id",$(this).data("address-id"))

            const deleteItem = await deleteAddressItem(formData)
            const fetchItems = await fetchAddressItems()
            
            hideOverlay()
            showNotification(deleteItem)
        }

        /* HELPERS */
        function showAddressUpdateForm(){
            $(".address_body").addClass("show_edit_address")
        }

        function hideAddressUpdateForm(){
            $(".address_body").removeClass("show_edit_address")
        }

        function hideAddressStoreForm(){
            $(".address_body").removeClass("show_new_address")
        }

        function hideProfileUpdateForm() {
            $(".fp_dash_personal_info").removeClass("show")
        }

        async function storeAddressItem(formData){
            let result
            showOverlay()
            await delay(1000)
            await $.ajax({
                type:"POST",
                url:"{{ route('front.customer.address.store.ajax') }}",
                processData: false,
                contentType: false,
                data: formData,
                success:function(res){
                    // console.log(res)
                    result = res
                },
                error: function(xhr) {
                    hideOverlay()
                    console.log(xhr.responseJSON)
                }
            })
            return result
        }

        async function deleteAddressItem(formData){
            let result
            showOverlay()
            await delay(1000)
            await $.ajax({
                type:"POST",
                url:"{{ route('front.customer.address.delete.ajax') }}",
                processData: false,
                contentType: false,
                data: formData,
                success:function(res){
                    // console.log(res)
                    result = res
                },
                error: function(xhr) {
                    hideOverlay()
                    console.log(xhr.responseJSON)
                }
            })
            return result
        }

        function fetchAddressItems(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.customer.address.items.ajax') }}",
                success:function(res){
                    $("[data-section=address-items]").html(res)
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }

        /* BASICS */
        async function executeAjax(url,formData){
            let response

            await delay()
            await $.ajax({
                type:formData ? "post" : "get",
                processData:false,
                contentType:false,
                data:formData,
                url,
                success:res=>{
                    // console.log(res)
                    response=res
                },
                error:err=>{
                    console.log(err.responseJSON)
                }
            })

            return response
        }

        function showNotification(res){
            iziToast.show({
                title:res.error?.message ?? res.success?.message,
                position:"topRight",
                color:res.error ? "red" : "green",
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

        function delay(ms=null) {
            return new Promise(resolve => setTimeout(resolve, ms ?? delayTime));
        }

        function resetForm(formSelector) {
            $(formSelector)[0].reset()
            $(formSelector).find("[data-alert]").text("")
        }
    })
</script>
@endpush