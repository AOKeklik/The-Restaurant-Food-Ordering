@extends("admin.layout.app")
@section("title", "Add Category")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Add Category</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.product.categories") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Categories
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.product.category.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"  value="{{ old("name") }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug*</label>
                        <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Parent Category</label>
                        <select name="parent_id" class="form-control select2">
                            <option value=""></option>
                            @foreach($categories as $category)
                                <option @if(old("parent_id") === $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error("parent_id") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Type*</label>
                        <select name="type" class="form-control select2">
                            <option value=""></option>
                            <option @if(old("type") === "product") selected @endif value="product">Product</option>
                            <option @if(old("type") === "page") selected @endif value="page">Page</option>
                            <option @if(old("type") === "menu") selected @endif value="menu">Menu</option>
                        </select>
                        @error("type") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
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
@push("scripts")
    <script>
        $(document).ready(function(){
            $("#name").change(function(e){
                $("[name=slug]").val(
                    $(this)
                        .val()
                        .trim()
                        .toLowerCase()
                        .replace(/[^\w ]+/ig,"")
                        .replace(/[\s-]+/ig,"-")
                        .replace(/-$/, "")
                )
            })
        })
    </script>
@endpush