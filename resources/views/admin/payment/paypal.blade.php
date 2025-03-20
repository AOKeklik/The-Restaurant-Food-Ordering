@extends("admin.layout.app")
@section("title", "Payment Paypal")
@section("link", route("front.index"))
@section("content")
<form action="{{ route("admin.payment.paypal.update") }}" method="POST" enctype="multipart/form-data" class="card">
    @csrf
    @method("POST")
    <div class="card-header">
        <!-- Submit Button -->
        <div class="text-start">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="mb-4">
                    <label for="paypal_logo" class="form-label">Paypal Logo*</label>
                    <img class="d-block py-1" src="{{ asset("uploads/payment") }}/{{ $paymentSettings["paypal_logo"] }}" alt="">
                    <input type="file" class="form-control" id="paypal_logo" name="paypal_logo" placeholder="Enter offer">
                    @error("paypal_logo") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_account_mode" class="form-label">Paypal Account Mode*</label>
                    <select name="paypal_account_mode" class="form-control select2">
                        <option @if("live" == $paymentSettings["paypal_account_mode"]) selected @endif value="live">live</option>
                        <option @if("sandbox" == $paymentSettings["paypal_account_mode"]) selected @endif value="sandbox">sandbox</option>
                    </select>
                    @error("paypal_account_mode") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_country" class="form-label">Paypal Country*</label>
                    <select name="paypal_country" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($val ===  $paymentSettings["paypal_country"]) selected @endif value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error("paypal_country") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_currency" class="form-label">Paypal Currency*</label>
                    <select name="paypal_currency" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($key ===  $paymentSettings["paypal_currency"]) selected @endif value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    @error("paypal_currency") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_rate" class="form-label">Paypal Rate*</label>
                    <input type="text" class="form-control" id="paypal_rate" name="paypal_rate" placeholder="Enter Charge"  value="{{ $paymentSettings["paypal_rate"] }}">
                    @error("paypal_rate") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_api_key" class="form-label">Paypal Api Key*</label>
                    <input type="text" class="form-control" id="paypal_api_key" name="paypal_api_key" placeholder="Enter Charge"  value="{{ $paymentSettings["paypal_api_key"] }}">
                    @error("paypal_api_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_secret_key" class="form-label">Paypal Secret Key*</label>
                    <input type="text" class="form-control" id="paypal_secret_key" name="paypal_secret_key" placeholder="Enter title"  value="{{ $paymentSettings["paypal_secret_key"] }}">
                    @error("paypal_secret_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="paypal_app_id" class="form-label">Paypal App Id*</label>
                    <input type="text" class="form-control" id="paypal_app_id" name="paypal_app_id" placeholder="Enter title"  value="{{ $paymentSettings["paypal_app_id"] }}">
                    @error("paypal_app_id") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label for="paypal_status" class="form-label d-block">Show</label>
                <input type="checkbox" @if($paymentSettings["paypal_status"] == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="paypal_status">
                @error("paypal_status") <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>
</form>
@endsection
@push("scripts")
    <script>
         $(document).ready(function () {
            $("input[type=file]").change(function (e) {
                $("img").attr("src",URL.createObjectURL(e.target.files[0]))
            })
        })
    </script>
@endpush