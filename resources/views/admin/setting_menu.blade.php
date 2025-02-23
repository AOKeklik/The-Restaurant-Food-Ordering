@extends("admin.layout.app")
@section("title", "Menu")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.setting.menu.update") }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Offer -->
                        <div class="mb-3">
                            <label for="menu_title" class="form-label">Title*</label>
                            <input type="text" class="form-control" id="menu_title" name="menu_title" placeholder="Enter offer"  value="{{ $provider_settings->menu_title }}">
                        </div>
                        @error("menu_title") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="menu_sub_title" class="form-label">Sub Title*</label>
                            <input type="text" class="form-control" id="menu_sub_title" name="menu_sub_title" placeholder="Enter title"  value="{{ $provider_settings->menu_sub_title }}">
                            @error("menu_sub_title") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-3">
                    <label for="menu_description" class="form-label">Description*</label>
                    <textarea class="form-control" id="menu_description" name="menu_description" rows="3" placeholder="Enter short description">{{ $provider_settings->menu_description }}</textarea>
                </div>
                @error("menu_description") <small class="text-danger">{{ $message }}</small> @enderror

                <div class="mb-3">
                    <label for="menu_status" class="form-label">Show*</label>
                    <input type="checkbox" @if($provider_settings->menu_status == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="menu_status">
                    @error("menu_status") <small class="text-danger">{{ $message }}</small> @enderror
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