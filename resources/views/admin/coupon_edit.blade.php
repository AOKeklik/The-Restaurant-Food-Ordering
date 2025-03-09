@extends("admin.layout.app")
@section("title", "Add Coupon")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Add Coupon</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.coupons") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Coupons
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.coupon.update") }}" method="POST">
            @csrf
            @method("POST")
            <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"  value="{{ $coupon->name }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code*</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" value="{{  $coupon->code }}">
                        @error("code") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Coupon Quantity*</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" value="{{  $coupon->quantity }}">
                        @error("quantity") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_purchase_amount" class="form-label">Min Purchase Amount*</label>
                        <input type="text" class="form-control" id="min_purchase_amount" name="min_purchase_amount" placeholder="Enter Amount" value="{{  $coupon->min_purchase_amount }}">
                        @error("min_purchase_amount") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="expire_date" class="form-label">Expire Date*</label>
                        <input 
                            value="{{ old("expire_date", $coupon->expire_date) }}"
                            min="{{ date('Y-m-d') }}"
                            type="date" class="form-control" id="expire_date" name="expire_date" placeholder="Enter Amount" 
                        >
                        @error("expire_date") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select id="discount_type" name="discount_type" class="form-control select2">
                            <option ></option>
                            @foreach(["percent","amount"] as $type)
                                <option @if($coupon->discount_type == $type) selected @endif value="{{ $type }}">
                                    {{ ucfirst($type) }} @if($type=="amount") {{ $provider_settings->site_currency_icon }} @else % @endif
                                </option>
                            @endforeach
                        </select>
                        @error("discount_type") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount*</label>
                        <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter Discount" value="{{ $coupon->discount }}">
                        @error("discount") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div class="text-end p-3">
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection