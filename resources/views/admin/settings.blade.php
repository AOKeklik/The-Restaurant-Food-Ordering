@extends("admin.layout.app")
@section("title", "Settings")
@section("link", route("front.index"))
@section("content")
<form action="{{ route("admin.settings.update") }}" method="POST" enctype="multipart/form-data" class="card">
    @csrf
    @method("POST")
    <div class="card-header">
        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-pills" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#site" role="tab" aria-controls="contact" aria-selected="false">Site</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#seo" role="tab" aria-controls="contact" aria-selected="false">Seo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#link" role="tab" aria-controls="contact" aria-selected="false">Link</a>
            </li>
        </ul>
        <div class="tab-content py-5" id="myTabContent2">
            <div class="tab-pane fade show active" id="site" role="tabpanel" aria-labelledby="site">
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Name*</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Enter offer"  value="{{ $provider_settings->site_name }}">
                            @error("site_name") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="site_currency" class="form-label">Site Currency*</label>
                            <select name="site_currency" class="form-control select2">
                                @foreach(config("currency.currency_list") as $key=>$val)
                                    <option @if($val ===  $provider_settings->site_currency) selected @endif value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @error("site_currency") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="site_currency_icon" class="form-label">Site Currency Icon*</label>
                            <input type="text" class="form-control" id="site_currency_icon" name="site_currency_icon" placeholder="Enter offer"  value="{{ $provider_settings->site_currency_icon }}">
                            @error("site_currency_icon") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="site_currency_position" class="form-label">Site Currency Direction*</label>
                            <select name="site_currency_position" class="form-control select2">
                                <option @if($provider_settings->site_currency_position === "right") selected @endif value="right">Right</option>
                                <option @if($provider_settings->site_currency_position === "left") selected @endif value="left">Left</option>
                            </select>
                            @error("site_currency_position") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="site_email" class="form-label">Site Email*</label>
                            <input type="text" class="form-control" id="site_email" name="site_email" placeholder="Enter title"  value="{{ $provider_settings->site_email }}">
                            @error("site_email") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="site_phone" class="form-label">Site Phone*</label>
                            <input type="text" class="form-control" id="site_phone" name="site_phone" placeholder="Enter title"  value="{{ $provider_settings->site_phone }}">
                            @error("site_phone") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="site_address" class="form-label">Site Address*</label>
                            <input type="text" class="form-control" id="site_address" name="site_address" placeholder="Enter title"  value="{{ $provider_settings->site_address }}">
                            @error("site_address") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="site_short_description" class="form-label">Site Short Description*</label>
                            <input type="text" class="form-control" id="site_short_description" name="site_short_description" placeholder="Enter title"  value="{{ $provider_settings->site_short_description }}">
                            @error("site_short_description") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 d-flex flex-column justify-content-between">
                        <label for="site_favicon" class="form-label">Site Favicon</label>
                        <div class="mb-3">
                            <img class="d-block py-1" src="{{ asset("uploads/setting") }}/{{ $provider_settings->site_favicon }}" alt="">
                            <input type="file" class="form-control" id="site_favicon" name="site_favicon" placeholder="Enter offer">
                            @error("site_favicon") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="site_top_logo" class="form-label">Site Top Logo</label>
                            <img class="d-block w-100 py-1" src="{{ asset("uploads/setting") }}/{{ $provider_settings->site_top_logo }}" alt="">
                            <input type="file" class="form-control" id="site_top_logo" name="site_top_logo" placeholder="Enter offer">
                            @error("site_top_logo") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="site_footer_logo" class="form-label">Site Footer Logo</label>
                            <img class="d-block w-100 py-1" src="{{ asset("uploads/setting") }}/{{ $provider_settings->site_footer_logo }}" alt="">
                            <input type="file" class="form-control" id="site_footer_logo" name="site_footer_logo" placeholder="Enter offer">
                            @error("site_footer_logo") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="seo_title" class="form-label">Seo Title</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Enter title"  value="{{ $provider_settings->seo_title }}">
                            @error("seo_title") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="seo_description" class="form-label">Seo Description</label>
                            <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Enter title"  value="{{ $provider_settings->seo_description }}">
                            @error("seo_description") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="seo_keywords" class="form-label">Seo Keywords</label>
                            <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="Enter title"  value="{{ $provider_settings->seo_keywords }}">
                            @error("seo_keywords") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="link_facebook" class="form-label">Link Facebook</label>
                            <input type="text" class="form-control" id="link_facebook" name="link_facebook" placeholder="Enter title"  value="{{ $provider_settings->link_facebook }}">
                            @error("link_facebook") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="link_linkedin" class="form-label">Link Linkedin</label>
                            <input type="text" class="form-control" id="link_linkedin" name="link_linkedin" placeholder="Enter title"  value="{{ $provider_settings->link_linkedin }}">
                            @error("link_linkedin") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="link_behance" class="form-label">Link Behance</label>
                            <input type="text" class="form-control" id="link_behance" name="link_behance" placeholder="Enter title"  value="{{ $provider_settings->link_behance }}">
                            @error("link_behance") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="link_twitter" class="form-label">Link Twitter</label>
                            <input type="text" class="form-control" id="link_twitter" name="link_twitter" placeholder="Enter title"  value="{{ $provider_settings->link_twitter }}">
                            @error("link_twitter") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push("scripts")
    <script>
        $(document).ready(function(){
            $("input[type=file]").change(function(e){
                $(this).closest("div").find("img").attr("src",URL.createObjectURL(e.target.files[0]))
            })
        })
    </script>
@endpush