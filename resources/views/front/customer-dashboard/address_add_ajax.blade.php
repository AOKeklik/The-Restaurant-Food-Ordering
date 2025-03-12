<div class="fp_dashboard_new_address">
    <form data-form="address-store">
        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::guard("user")->user()->id }}">
        <div class="row">
            <div class="col-12">
                <h4>add new address</h4>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="fp__check_single_form">
                    <input type="text" placeholder="First Name*" id="first_name" name="first_name" value="{{ old("first_name") }}">
                    <small data-alert="address-store-first_name" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="fp__check_single_form">
                    <input type="text" placeholder="Last Name" id="last_name" name="last_name" value="{{ old("last_name") }}">
                    <small data-alert="address-store-last_name" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="fp__check_single_form">
                    <input type="text" placeholder="Phone *" id="phone" name="phone" value="{{ old("phone") }}">
                    <small data-alert="address-store-phone" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="fp__check_single_form">
                    <input type="email" placeholder="Email *" id="email" name="email" value="{{ old("email") }}">
                    <small data-alert="address-store-email" class="form-text text-danger"></small>
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
                    <small data-alert="address-store-delivery_area_id" class="form-text text-danger"></small>
                </div>
            </div>

            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="fp__check_single_form">
                    <textarea cols="3" rows="4" placeholder="Address" id="address" name="address">{{ old("address") }}</textarea>
                    <small data-alert="address-store-address" class="form-text text-danger"></small>
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
                    <small data-alert="address-store-type" class="form-text text-danger"></small>
                </div>
            </div>

            <div class="col-12">
                <button data-btn="address-cancel" type="button" class="common_btn">cancel</button>
                <button data-btn="address-store" type="button" class="common_btn">save address</button>
            </div>
        </div>
    </form>
</div>