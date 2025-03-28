{{-- address --}}
<div class="col-lg-8 col-lg-7">
    <div class="fp__checkout_form">
        <div class="fp__check_form">
            <h5>
                select address 
                <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i class="far fa-plus"></i> add address</a>
            </h5>
            <div class="row">
                @foreach($addresses as $address)
                    <div class="col-md-6">
                        <div class="fp__checkout_single_address">
                            <div class="form-check">
                                <input 
                                    @if(isset(Session::get("cart")["address"]["id"]) && Session::get("cart")["address"]["id"] == $address->id) checked @endif 
                                    data-address-id="{{ $address->id }}" class="form-check-input" type="radio" name="address" value="{{ $address->id }}" id="{{ $address->id }}">
                                <label class="form-check-label" for="{{ $address->id }}">
                                    <span class="icon"><i class="fas fa-home"></i> {!! $address->type !!}</span>
                                    <span class="address">{!! $address->address !!} ({!! $address->deliveryArea->name !!})</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <form>
                <div class="row">
                    <div class="col-12">
                        <h5>billing address</h5>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Company Name (Optional)">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <select id="select_js3">
                                <option value="">select country</option>
                                <option value="">bangladesh</option>
                                <option value="">nepal</option>
                                <option value="">japan</option>
                                <option value="">korea</option>
                                <option value="">thailand</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Street Address *">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Apartment, suite, unit, etc. (optional)">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Town / City *">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="State *">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Zip *">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="text" placeholder="Phone *">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="fp__check_single_form">
                            <input type="email" placeholder="Email *">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="fp__check_single_form">
                            <h5>Additional Information</h5>
                            <textarea cols="3" rows="4"  placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{{-- cart --}}
@include("front.component.cart")