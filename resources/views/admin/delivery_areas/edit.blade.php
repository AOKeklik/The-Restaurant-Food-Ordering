@extends("admin.layout.app")
@section("title", "Edit Delivery Area")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Edit Delivery Area</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.delivery_areas") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Areas
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.delivery_area.update") }}" method="POST">
            @csrf
            @method("POST")
            <input type="hidden" name="delivery_area_id" value="{{ $deliveryArea->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"  value="{{ $deliveryArea->name }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fee" class="form-label">Delivery Fee</label>
                        <input type="text" class="form-control" id="fee" name="fee" placeholder="Enter Fee" value="{{ $deliveryArea->fee }}">
                        @error("fee") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_time" class="form-label">Min Delivery Time</label>
                        <input value="{{ $deliveryArea->min_time }}" type="text" class="form-control" id="min_time" name="min_time">
                        @error("min_time") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_time" class="form-label">Max Delivery Time</label>
                        <input value="{{ $deliveryArea->max_time }}" type="text" class="form-control" id="max_time" name="max_time">
                        @error("max_time") <small class="text-danger">{{ $message }}</small> @enderror
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