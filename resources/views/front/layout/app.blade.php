@include("front.layout.header");
@include("front.layout.nav_top");
@include("front.layout.nav_bottom");

@yield("content")

<!--=============================
            LOADER
==============================-->
<div class="overlay-container d-none">
    <div class="overlay">
        <span class="loader"></span>
    </div>
</div>
<!--=============================
            LOADER
==============================-->




<!--=============================
    SCROLL BUTTON START
==============================-->
<div class="fp__scroll_btn">
    go to top
</div>
<!--=============================
    SCROLL BUTTON END 
==============================-->



<!--=============================
            CARD POPUP
==============================-->
<div class="fp__cart_popup">
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body load_product_modal_body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!--=============================
            CARD POPUP
==============================-->


@include("front.layout.footer");


