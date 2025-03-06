    <!--=============================
        FOOTER START
    ==============================-->
    <footer>
        <div class="footer_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container wow fadeInUp" data-wow-duration="1s">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-sm-8 col-md-6">
                        <div class="fp__footer_content">
                            <a class="footer_logo" href="{{ route("front.index") }}">
                                <img src="{{ asset("uploads/setting") }}/{{ $provider_settings->site_footer_logo }}" alt="FoodPark" class="img-fluid w-100">
                            </a>
                            <span>{{ $provider_settings->site_short_description }}</span>
                            <p class="info"><i class="far fa-map-marker-alt"></i> {{ $provider_settings->site_address }}</p>
                            <a class="info" href="callto:{{ $provider_settings->site_phone }}"><i class="fas fa-phone-alt"></i>{{ $provider_settings->site_phone }}</a>
                            <a class="info" href="mailto:{{ $provider_settings->site_email }}"><i class="fas fa-envelope"></i>{{ $provider_settings->site_email }}</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="fp__footer_content">
                            <h3>Short Link</h3>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Our Service</a></li>
                                <li><a href="#">gallery</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="fp__footer_content">
                            <h3>Help Link</h3>
                            <ul>
                                <li><a href="#">Terms And Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-8 col-md-6 order-lg-4">
                        <div class="fp__footer_content">
                            <h3>subscribe</h3>
                            <form>
                                <input type="text" placeholder="Subscribe">
                                <button>Subscribe</button>
                            </form>
                            <div class="fp__footer_social_link">
                                <h5>follow us:</h5>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fp__footer_bottom d-flex flex-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="fp__footer_bottom_text d-flex flex-wrap justify-content-between">
                            <p>Copyright 2022 <b>FoodPark</b> All Rights Reserved.</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">payment</a></li>
                                <li><a href="#">settings</a></li>
                                <li><a href="#">privacy policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=============================
        FOOTER END
    ==============================-->


    <!--jquery library js-->
    <script src="{{ asset("dist/front/js/jquery-3.6.0.min.js") }}"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset("dist/front/js/Font-Awesome.js") }}"></script>    
    <script src="{{ asset("dist/front/js/slick.min.js") }}"></script>   
    <script src="{{ asset("dist/front/js/isotope.pkgd.min.js") }}"></script>    
    <script src="{{ asset("dist/front/js/simplyCountdown.js") }}"></script>   
    <script src="{{ asset("dist/front/js/jquery.waypoints.min.js") }}"></script>
    <script src="{{ asset("dist/front/js/jquery.countup.min.js") }}"></script>    
    <script src="{{ asset("dist/front/js/jquery.nice-select.min.js") }}"></script>
    <script src="{{ asset("dist/front/js/venobox.min.js") }}"></script>    
    <script src="{{ asset("dist/front/js/sticky_sidebar.js") }}"></script>
    <script src="{{ asset("dist/front/js/wow.min.js") }}"></script>    
    <script src="{{ asset("dist/front/js/jquery.exzoom.js") }}"></script>
    <script src="{{ asset("dist/front/js/iziToast.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src=https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <!--main/custom js-->
    <script src="{{ asset("dist/front/js/main.js") }}"></script>
    
    @stack("scripts")
    @include('front.layout.global-scripts')
</body>

</html>