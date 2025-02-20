@extends("admin.layout.app")
@section("title", "Why Choose")
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Why Chooses</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.why_choose.add") }}" class="btn btn-primary">
                Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.setting.why_choose.update") }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Offer -->
                        <div class="mb-3">
                            <label for="why_choose_title" class="form-label">Title*</label>
                            <input type="text" class="form-control" id="why_choose_title" name="why_choose_title" placeholder="Enter offer"  value="{{ $provider_settings->why_choose_title }}">
                        </div>
                        @error("why_choose_title") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="why_choose_sub_title" class="form-label">Sub Title*</label>
                            <input type="text" class="form-control" id="why_choose_sub_title" name="why_choose_sub_title" placeholder="Enter title"  value="{{ $provider_settings->why_choose_sub_title }}">
                            @error("why_choose_sub_title") <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-3">
                    <label for="why_choose_description" class="form-label">Description*</label>
                    <textarea class="form-control" id="why_choose_description" name="why_choose_description" rows="3" placeholder="Enter short description">{{ $provider_settings->why_choose_description }}</textarea>
                </div>
                @error("why_choose_description") <small class="text-danger">{{ $message }}</small> @enderror

                <div class="mb-3">
                    <label for="why_choose_status" class="form-label">Show*</label>
                    <input type="checkbox" @if($provider_settings->why_choose_status == 1) checked @endif data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger" name="why_choose_status">
                    @error("why_choose_status") <small class="text-danger">{{ $message }}</small> @enderror
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
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($whyChooses as $whyChoose)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <i class="{{ $whyChoose->icon }}"></i>
                            </td>
                            <td>{{ $whyChoose->title }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="status" 
                                        data-why-choose-id="{{ $whyChoose->id }}"
                                        @if($whyChoose->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route("admin.why_choose.edit",["why_choose_id"=>$whyChoose->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-why-choose-id="{{ $whyChoose->id }}" href="" class="btn btn-danger slide_delete">
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
                const why_choose_id =$(this).data("why-choose-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("why_choose_id",why_choose_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.why_choose.status.update') }}",
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
                        const why_choose_id =$(this).data("why-choose-id")
                        const formData=new FormData()

                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve, 1000))

                        formData.append("_token", "{{ csrf_token() }}")
                        formData.append("why_choose_id",why_choose_id)

                        $.ajax({
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            url: "{{ route('admin.why_choose.delete') }}",
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