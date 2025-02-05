@extends("admin.layout.app")
@section("title","Profile")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Profile Edit</h4>
                </div>
                <form action="{{ route("admin.profile.update") }}" method="POST" class="card-body row" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-md-3 px-5">
                                <img src="{{ asset("uploads/admin") }}/{{ Auth::guard("user")->user()->avatar }}" alt="" class="w-100">
                            </div>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Photo</label>
                                    @error("avatar") <span class="form-text text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="{{ Auth::guard("user")->user()->name }}">
                            @error("name") <span class="form-text text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control" value="{{ Auth::guard("user")->user()->email }}">
                            @error("email") <span class="form-text text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input name="current_password" type="text" class="form-control">
                            @error("current_password") <span class="form-text text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>New Password</label>
                            <input name="password" type="text" class="form-control">
                            @error("password") <span class="form-text text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input name="confirm_password" type="text" class="form-control">
                            @error("confirm_password") <span class="form-text text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                </form>
            </div> 
        </div>
    </section>
</div>
@push("scripts")
<script>
    $(document).ready(function(){
        $("input[type=file]").change(function(e){
            $(this).closest("form").find("img").attr("src",URL.createObjectURL(e.target.files[0]))
        })
    })
</script>
@endpush
@endsection