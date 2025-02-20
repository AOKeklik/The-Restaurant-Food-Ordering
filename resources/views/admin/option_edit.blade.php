@extends("admin.layout.app")
@section("title", "Edit Option")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Edit Option</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.options") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Options
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.option.update") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="hidden" name="option_id" value="{{ request()->route("option_id") }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"  value="{{ $option->name }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price*</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="{{ $option->price }}">
                        @error("price") <small class="text-danger">{{ $message }}</small> @enderror
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