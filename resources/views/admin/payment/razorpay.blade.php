@extends("admin.layout.app")
@section("title", "Payment Razorpay")
@section("link", route("front.index"))
@section("content")
<form action="{{ route("admin.payment.razorpay.update") }}" method="POST" enctype="multipart/form-data" class="card">
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
                    <label for="razorpay_logo" class="form-label">Razorpay Logo*</label>
                    <img class="d-block py-1" src="{{ asset("uploads/payment") }}/{{ $paymentSettings["razorpay_logo"] }}" alt="">
                    <input type="file" class="form-control" id="razorpay_logo" name="razorpay_logo" placeholder="Enter offer">
                    @error("razorpay_logo") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="razorpay_country" class="form-label">Razorpay Country*</label>
                    <select name="razorpay_country" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($val ===  $paymentSettings["razorpay_country"]) selected @endif value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error("razorpay_country") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="razorpay_currency" class="form-label">Razorpay Currency*</label>
                    <select name="razorpay_currency" class="form-control select2">
                        @foreach(config("list_currency") as $key=>$val)
                            <option @if($key ===  $paymentSettings["razorpay_currency"]) selected @endif value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    @error("razorpay_currency") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="razorpay_rate" class="form-label">Razorpay Rate*</label>
                    <input type="text" class="form-control" id="razorpay_rate" name="razorpay_rate" placeholder="Enter Charge"  value="{{ $paymentSettings["razorpay_rate"] }}">
                    @error("razorpay_rate") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="razorpay_api_key" class="form-label">Razorpay Api Key*</label>
                    <input type="text" class="form-control" id="razorpay_api_key" name="razorpay_api_key" placeholder="Enter Charge"  value="{{ $paymentSettings["razorpay_api_key"] }}">
                    @error("razorpay_api_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="razorpay_secret_key" class="form-label">Razorpay Secret Key*</label>
                    <input type="text" class="form-control" id="razorpay_secret_key" name="razorpay_secret_key" placeholder="Enter title"  value="{{ $paymentSettings["razorpay_secret_key"] }}">
                    @error("razorpay_secret_key") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label for="razorpay_status" class="form-label d-block">Show</label>
                <input type="checkbox" @if($paymentSettings["razorpay_status"] == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="razorpay_status">
                @error("razorpay_status") <small class="text-danger">{{ $message }}</small> @enderror
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