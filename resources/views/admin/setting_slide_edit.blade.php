@extends("admin.layout.app")
@section("title", "Edit Slide")
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Header</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.setting.slides") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Slides
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.setting.slide.update") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="hidden" name="slide_id" value="{{ $slide->id }}">
            <!-- Image Upload -->
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset("uploads/slider/") }}/{{ $slide->image }}" alt="" class="w-100 p-5">
                </div>
                <div class="col-md-9">
                    <label for="image" class="form-label">Image*</label>
                    <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input" id="image">
                        <label class="custom-file-label" for="image" name="image">Choose file</label>
                    </div>
                    @error("image") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Offer -->
                    <div class="mb-3">
                        <label for="offer" class="form-label">Offer*</label>
                        <input type="text" class="form-control" id="offer" name="offer" placeholder="Enter offer"  value="{{ $slide->offer }}">
                    </div>
                    @error("offer") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"  value="{{ $slide->title }}">
                        @error("title") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Sub-Title -->
                    <div class="mb-3">
                        <label for="sub_title" class="form-label">Sub-Title*</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Enter sub-title" value="{{ $slide->sub_title }}">
                    </div>
                    @error("sub_title") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <!-- Button Link -->
                    <div class="mb-3">
                        <label for="button_link" class="form-label">Button Link</label>
                        <input type="url" class="form-control" id="button_link" name="button_link" placeholder="Enter button link" value="{{ $slide->button_link }}">
                    </div>
                    @error("button_link") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <!-- Short Description -->
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description*</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="3" placeholder="Enter short description">{{ $slide->short_description }}</textarea>
            </div>
            @error("short_description") <small class="text-danger">{{ $message }}</small> @enderror

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
@push("scripts")
    <script>
        $(document).ready(function(){
            $("#image").change(function(e){
                $(this).closest(".row").find('img').attr("src",URL.createObjectURL(e.target.files[0]))
            })
        })
    </script>
@endpush