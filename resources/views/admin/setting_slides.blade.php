@extends("admin.layout.app")
@section("title", "Slides")
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Header</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.setting.slide.add") }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.setting.slider.update") }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <!-- Image Upload -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <img src="{{ asset("uploads/setting") }}/{{ $provider_settings->slider_photo }}" alt="" class="w-100">
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="form-label">Image*</label>
                        <input name="slider_photo" type="file" class="form-control" id="slider_photo">
                        @error("slider_photo") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="slider_status" class="form-label">Show*</label>
                    <input type="checkbox" @if($provider_settings->slider_status == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="slider_status">
                    @error("slider_status") <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <hr class="my-5">
        <div class="table-responsive" >
            <table class="table table-bordered table-md" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slides as $slide)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img style="width:75px" src="{{ asset("uploads/slider/") }}/{{ $slide->image }}" alt="">
                            </td>
                            <td>{{ $slide->title }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="status" 
                                        data-slide-id="{{ $slide->id }}"
                                        @if($slide->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route("admin.setting.slide.edit",["slide_id"=>$slide->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-slide-id="{{ $slide->id }}" href="" class="btn btn-danger slide_delete">
                                    <span class="button-loader"></span>
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push("scripts")
    <script>
        /* image */
        $(document).ready(function(){
            $("#slider_photo").change(function(e){
                $(this).closest(".row").find('img').attr("src",URL.createObjectURL(e.target.files[0]))
            })
        })

        /* update */
        $(document).ready(function(){
            $(".status").change(async function(){

                const el = $(this).closest(".d-inline")
                const slide_id =$(this).data("slide-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("slide_id",slide_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.setting.slide.status.update') }}",
                    success:function(res){
                        console.log(res)

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            color: res.error ? "red" : "green",
                            position: "topRight",
                        })

                        el.removeClass("pending")
                        el.addClass("active")
                    }
                })
            })
        })

        /* delete */
        $(document).ready(function(){
            $(".slide_delete").click(async function(e){
                e.preventDefault()


                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to delete this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(async (result) => {
                    if (result.isConfirmed) {


                        const el = $(this)
                        const parent = $(this).closest("tr")
                        const slide_id =$(this).data("slide-id")
                        const formData=new FormData()

                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve, 1000))

                        formData.append("_token", "{{ csrf_token() }}")
                        formData.append("slide_id",slide_id)

                        $.ajax({
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            url: "{{ route('admin.setting.slide.delete') }}",
                            success:function(res){
                                console.log(res)

                                iziToast.show({
                                    title: res.error?.message ?? res.success?.message,
                                    color: res.error ? "red" : "green",
                                    position: "topRight",
                                })

                                if(res.success){
                                    parent.slideUp()
                                }

                                el.removeClass("pending")
                                el.addClass("active")
                            }
                        })
                    }
                });

                
            })
        })
    </script>
@endpush