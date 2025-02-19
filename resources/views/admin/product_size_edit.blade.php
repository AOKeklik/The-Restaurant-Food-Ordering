@extends("admin.layout.app")
@section("title", "Product Edit Size")
@section("link", route("front.products"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Size</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.product.sizes",["product_id"=>$size->product_id]) }}" class="btn btn-primary">
                Sizes
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.product.size.update") }}" method="POST">
                @csrf
                @method("POST")
                <input type="hidden" name="product_id" value="{{ $size->product_id }}">
                <input type="hidden" name="size_id" value="{{ request("size_id") }}">
                <!-- Image Upload -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $size->name }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price*</label>
                        <input name="price" type="text" class="form-control" id="price" value="{{ $size->price }}">
                        @error("price") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection