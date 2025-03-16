@extends("front.layout.app")
@section("title", "Checkout")
@section("page_title", "Checkout Detail")
@section("content")

<!--=============================
    BREADCRUMB START
==============================-->
@include("front.component.bread_crumb")
<!--=============================
    BREADCRUMB END
==============================-->

<!--============================
    CHECK OUT PAGE START
==============================-->
<section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
    <div class="container">
        <div data-section="checkout-page" class="row wow fadeInUp" data-wow-duration="1s">
            @include("front.checkout.ajax_page")
        </div>
    </div>
</section>
<!--============================
    CHECK OUT PAGE END
==============================-->
@php echo "<pre>";print_r(Session::get("cart"));echo "</pre>"; @endphp
<!--============================
    ADD ADDRESS FORM
==============================-->
<div class="fp__address_modal">
    <div class="modal fade" id="address_modal" class="address_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="address_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="address_modalLabel">add new address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="fp_dashboard_new_address d-block">
                    <form data-form="checkout-address-store">
                        @if(Auth::guard("user")->check())<input type="hidden" id="user_id" name="user_id" value="{{ Auth::guard("user")->user()->id }}">@endif
                        <div class="row">
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="First Name*" id="first_name" name="first_name" value="{{ old("first_name") }}">
                                    <small data-alert="checkout-address-store-first_name" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Last Name" id="last_name" name="last_name" value="{{ old("last_name") }}">
                                    <small data-alert="checkout-address-store-last_name" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Phone *" id="phone" name="phone" value="{{ old("phone") }}">
                                    <small data-alert="checkout-address-store-phone" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="email" placeholder="Email *" id="email" name="email" value="{{ old("email") }}">
                                    <small data-alert="checkout-address-store-email" class="form-text text-danger"></small>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="fp__check_single_form">
                                    <select class="niceselect2" id="delivery_area_id" name="delivery_area_id">
                                        <option>select Delivery Area</option>
                                        @foreach($deliveryAreas as $deliveryArea)
                                            <option @if($deliveryArea->id == old("delivery_area_id")) selected @endif value="{{ $deliveryArea->id }}">
                                                {{ $deliveryArea->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small data-alert="checkout-address-store-delivery_area_id" class="form-text text-danger"></small>
                                </div>
                            </div>
                
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="fp__check_single_form">
                                    <textarea cols="3" rows="4" placeholder="Address" id="address" name="address">{{ old("address") }}</textarea>
                                    <small data-alert="checkout-address-store-address" class="form-text text-danger"></small>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="fp__check_single_form check_area">
                                    <div class="form-check">
                                        <input class="form-check-input type" type="radio" name="type" value="home" id="flexRadioDefault1" @if("home" == old("type")) checked @endif>
                                        <label class="form-check-label" for="flexRadioDefault1">  home  </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input type" type="radio" name="type" value="office" id="flexRadioDefault2" @if("office" == old("type")) checked @endif>
                                        <label class="form-check-label" for="flexRadioDefault2"> office </label>
                                    </div>
                                    <small data-alert="checkout-address-store-type" class="form-text text-danger"></small>
                                </div>
                            </div>
                
                            <div class="col-12 d-flex gap-5">
                                <button data-btn="checkout-address-cancel" type="button" class="common_btn">cancel</button>
                                <button data-btn="checkout-store-address" type="button" class="common_btn">save address</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============================
    ADD ADDRESS FORM
==============================-->

@endsection
@push("scripts")
    <script>
        /* ///////////////////////////////
                    CHECKOUT
        // /////////////////////////////// */
        $(document).ready(function() {          
            $(document)
                .on("click","[data-btn=checkout-address-cancel]",handlerCheckoutAddressCancel)
                .on("click","[data-btn=checkout-store-address]",handlerCheckoutStoreAddresses)
                .on("change","[data-address-id]",handlerCheckoutStoreAddress)

            function handlerCheckoutAddressCancel (e){
                e.preventDefault()
                hideModal()
            }

            async function handlerCheckoutStoreAddresses(e){
                e.preventDefault()

                const formData=new FormData()
                const form = $("[data-form=checkout-address-store]")

                formData.append("_token","{{ csrf_token() }}")
                formData.append("user_id",form.find("#user_id").val())
                formData.append("first_name",form.find("#first_name").val())
                formData.append("last_name",form.find("#last_name").val())
                formData.append("phone",form.find("#phone").val())
                formData.append("email",form.find("#email").val())
                formData.append("delivery_area_id",form.find("#delivery_area_id").val())
                formData.append("address",form.find("#address").val())
                formData.append("type",form.find("input.type:checked").val())

                
                const store = await storeAddreses(formData)

                if(store.error) {
                    resetForm(form)
                    hideOverlay()
                    showNotification(store)
                    hideModal()
                    return
                }
                
                if(store.error_form) {
                    hideOverlay()
                    $("[data-alert^=checkout-address-store]").html("")
                    Object.keys(store.error_form.message).forEach(key => {
                        const message = store.error_form.message[key][0]
                        $("[data-alert=checkout-address-store-"+key+"]").html(message)
                    })

                    return
                }

                const fetch = await fetchCheckoutPage()

                resetForm(form)
                hideOverlay()
                showNotification(store)
                hideModal()
            }

            async function handlerCheckoutStoreAddress(e){
                try{
                    e.preventDefault()

                    const formData=new FormData()
                    const address_id = $(this).data("address-id")

                    formData.append("_token","{{ csrf_token() }}")
                    formData.append("address_id",address_id)

                    showOverlay()
                    await delay(1000)

                    const store = await storeAddress(formData)

                    if(store.error)
                        throw new Error(store.error.message)

                    const fetch = await fetchCheckoutPage()

                    showNotification(store)
                }catch(err){
                    showNotification({ error: { message: err.message || 'An unexpected error occurred' } })
                } finally {
                    hideOverlay()
                }
            }

            async function storeAddreses(formData){
                let result
                showOverlay()
                await delay(1000)
                await $.ajax({
                    type:"POST",
                    url:"{{ route('front.order.checkout.store.ajax.addresses') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    headers:{
                        "X-Page-URL": window.location.href
                    },
                    success: res=>{
                        // console.log(res)
                        result = res
                    },
                    error: xhr=>{
                        console.log(xhr.responseJSON)
                    }
                })
                return result
            }

            async function storeAddress(formData){
                let result
                await $.ajax({
                    type:"POST",
                    url:"{{ route('front.order.checkout.store.ajax.address') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success:function(res){
                        // console.log(res)
                        result = res
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON)
                    }
                })
                return result
            }

            function fetchCheckoutPage(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('front.order.checkout.view.ajax.page') }}",
                    success:function(res){
                        $("[data-section=checkout-page]").html(res)
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON)
                    }
                })
            }

            function hideModal(){
                $('#address_modal').modal('hide');
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

            function resetForm(formSelector) {
                $(formSelector)[0].reset()
                $(formSelector).find("[data-alert]").text("")
            }

            function showNotification(res){
                iziToast.show({
                    title: res.error?.message ?? res.success?.message,
                    position: "topRight",
                    color: res.error ? "red" : "green"
                })
            }

            function redirect(res,callback=()=>{}){
                console.log(res)
                
                if(res.redirect) {
                    window.location.href=res.redirect.link
                    return
                }
                
                callback()
            }

        })
    </script>
@endpush