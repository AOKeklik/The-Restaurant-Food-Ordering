@extends("admin.layout.app")
@section("title", "Add Product")
@section("link", route("front.products"))
@section("content")
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Procut Form</h4>
        <a href="{{ route("admin.products") }}" class="btn btn-primary"><i class="fa fa-eye"></i> Products</a>
    </div>
    <div class="card-body">
        <form class="row" action="{{ route("admin.product.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("post")
            <div class="form-group col-md-4">
                <img class="w-100" src="https://placehold.co/600x400?text=Hello\nWorld" alt="">
            </div>
            <div class="form-group col-md-8">
                <label for="image">Image*</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Image">
                @error("image") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="category_id ">Caterory*</label>
                <select id="category_id" name="category_id" class="form-control">
                    <option value=""></option>
                    @foreach($categories as $cat)
                        <option @if(old("category_id") == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error("category_id") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="name">Name*</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ old("name") }}">
                @error("name") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-12">
                <label for="options">Options</label>
                <select id="options" name="options[]" class="form-control select2" multiple>
                    @foreach($options as $option)
                        <option @if(in_array($option->id,old("options",[]))) selected @endif value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                @error("options") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="price">Price*</label>
                <input name="price" type="text" class="form-control" id="price" placeholder="Password" value="{{ old("price") }}">
                @error("price") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="offer_price">Offer Price</label>
                <input name="offer_price" type="text" class="form-control" id="offer_price" placeholder="Offer Price" value="{{ old("offer_price") }}">
                @error("offer_price") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="seo_title">Seo Title</label>
                <input name="seo_title" type="text" class="form-control" id="seo_title" placeholder="Seo Title" value="{{ old("seo_title") }}">
                @error("seo_title") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="seo_description">Seo Description</label>
                <input name="seo_description" type="text" class="form-control" id="seo_description" placeholder="Seo Description" value="{{ old("seo_description") }}">
                @error("seo_description") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="short_description">Short Description</label>
                <input name="short_description" type="text" class="form-control" id="short_description" placeholder="Short Description" value="{{ old("short_description") }}">
                @error("short_description") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-12">
                <label for="description">Description*</label>
                <textarea name="description" type="text" class="form-control summernote" id="description" placeholder="Description">{{ old("description") }}</textarea>
                @error("description") <small class="form-text text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push("scripts")
    <script>
        $(document).ready(function(){
            /* img */
            $("#image").change(function(e){
                $(this).closest("form").find("img").attr("src", URL.createObjectURL(e.target.files[0]))
            })

             /* slug */
             $("#name").change(function(e){
                $("#slug").val(
                    $(this)
                        .val()
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w ]/g,"")
                        .replace(/[\s-]+/g,"-")
                        .replace(/-$/, "")
                )
            })
        })
    </script>
@endpush