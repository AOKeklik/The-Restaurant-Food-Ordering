@extends("admin.layout.app")
@section("title", "Payment Stripe")
@section("link", route("front.index"))
@section("content")
<form action="{{ route("admin.payment.stripe.update") }}" method="POST" enctype="multipart/form-data" class="card">
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
                    <label for="stripe_logo" class="form-label">Stripe Logo*</label>
                    <img class="d-block py-1" src="{{ asset("uploads/payment") }}/{{ $paymentSettings["stripe_logo"] }}" alt="">
                    <input type="file" class="form-control" id="stripe_logo" name="stripe_logo" placeholder="Enter offer">
                    @error("stripe_logo") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_country" class="form-label">Stripe Country*</label>
                    <select name="stripe_country" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($val ===  $paymentSettings["stripe_country"]) selected @endif value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error("stripe_country") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_currency" class="form-label">Stripe Currency*</label>
                    <select name="stripe_currency" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($key ===  $paymentSettings["stripe_currency"]) selected @endif value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    @error("stripe_currency") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_rate" class="form-label">Stripe Rate*</label>
                    <input type="text" class="form-control" id="stripe_rate" name="stripe_rate" placeholder="Enter Charge"  value="{{ $paymentSettings["stripe_rate"] }}">
                    @error("stripe_rate") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_api_key" class="form-label">Stripe Api Key*</label>
                    <input type="text" class="form-control" id="stripe_api_key" name="stripe_api_key" placeholder="Enter Charge"  value="{{ $paymentSettings["stripe_api_key"] }}">
                    @error("stripe_api_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_secret_key" class="form-label">Stripe Secret Key*</label>
                    <input type="text" class="form-control" id="stripe_secret_key" name="stripe_secret_key" placeholder="Enter title"  value="{{ $paymentSettings["stripe_secret_key"] }}">
                    @error("stripe_secret_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label for="stripe_status" class="form-label d-block">Show</label>
                <input type="checkbox" @if($paymentSettings["stripe_status"] == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="stripe_status">
                @error("stripe_status") <small class="text-danger">{{ $message }}</small> @enderror
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