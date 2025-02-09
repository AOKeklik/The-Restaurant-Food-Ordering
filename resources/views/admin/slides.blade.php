@extends("admin.layout.app")
@section("title", "Slides")
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Header</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.slide.add") }}" class="btn btn-primary">
                Add New
            </a>
        </div>
    </div>
    <div class="card-body">
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
                                <div class="badge badge-success" style="@if($slide->status == 0) display:none @endif">Active</div>
                                <div class="badge badge-danger" style="@if($slide->status == 1) display:none @endif">Inactive</div>
                            </td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="checkbox_slide_status" 
                                        data-slide-id="{{ $slide->id }}"
                                        @if($slide->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                                <a href="{{ route("admin.slide.edit",["slide_id"=>$slide->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
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
        /* update */
        $(document).ready(function(){
            $(".checkbox_slide_status").change(async function(){

                const el = $(this).closest(".d-inline")
                const on = $(this).closest("tr").find(".badge.badge-success")
                const off = $(this).closest("tr").find(".badge.badge-danger")
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
                    url: "{{ route('admin.slide.status.update') }}",
                    success:function(res){
                        console.log(res)

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            color: res.error ? "red" : "green",
                            position: "topRight",
                        })

                        if(res.success){
                            if(status === 1){
                                on.show()
                                off.hide()
                            }else{
                                on.hide()
                                off.show()
                            }
                        }

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
                            url: "{{ route('admin.slide.delete') }}",
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