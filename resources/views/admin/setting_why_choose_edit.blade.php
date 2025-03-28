@extends("admin.layout.app")
@section("title", "Edit Why Choose")
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Edit Choose</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.setting.why_chooses") }}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Edit Choose
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.setting.why_choose.update") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="hidden" name="why_choose_id" value="{{ $whyChooses->id }}">
            <!-- Image Upload -->
            <div class="row">
                <div class="col-md-3 d-flex justify-content-center align-items-center">
                    <i class="{{ $whyChooses->icon }} fs-1"></i>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon*</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter icon"  value="{{ $whyChooses->icon }}">
                    </div>
                    @error("icon") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"  value="{{ $whyChooses->title }}">
                        @error("title") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter short description">{{ $whyChooses->description }}</textarea>
                    </div>
                    @error("description") <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
@push("scripts")
    <script>
        $(document).ready(function(){
            $("#icon").change(function(e){
                $(this).closest(".row").find('i').attr("class",$(this).val().trim() + " fs-1")
            })
        })
    </script>
@endpush