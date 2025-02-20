@extends("admin.layout.app")
@section("title", "Options")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Option</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.option.add") }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
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
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($options as $option)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $option->name }}</td>
                            <td>${{ $option->price }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="option_status" 
                                        data-option-id="{{ $option->id }}"
                                        @if($option->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route("admin.option.edit",["option_id"=>$option->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-option-id="{{ $option->id }}" href="" class="btn btn-danger option_delete">
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
        $(document).ready(function(){

            /* update status */
            $(".option_status").change(async function(e){
                
                const el=$(this).closest(".d-inline")
                const status=$(this).prop("checked") ? 1 : 0
                const option_id=$(this).data("option-id")
                const formData=new FormData()

                
                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                formData.append("status",status)
                formData.append("option_id",option_id)
                formData.append("_token", "{{ csrf_token() }}")
                
                $.ajax({
                    url: "{{ route('admin.option.status.update') }}",
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(res){
                        iziToast.show({
                            title:res.error?.message ?? res.success?.message,
                            color:res.error ? "red":"green",
                            position:"topRight"
                        })

                        el.removeClass("pending")
                        el.addClass("active")
                    }
                })
            })  
            
            /* deletes */
            $(".option_delete").click(async function(e){
                e.preventDefault()

                const tr=$(this).closest("tr")
                const el=$(this)
                const option_id=$(this).data("option-id")
                const formData=new FormData()

                Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then( async (result) => {
                    if (result.isConfirmed) {
                        
                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve,1000))
                        
                        formData.append("option_id",option_id)
                        formData.append("_token", "{{ csrf_token() }}")
                        
                        $.ajax({
                            url: "{{ route('admin.option.delete') }}",
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            success:function(res){
                                iziToast.show({
                                    title:res.error?.message ?? res.success?.message,
                                    color:res.error ? "red":"green",
                                    position:"topRight"
                                })

                                if(res.success){
                                    tr.slideUp()
                                }
                            }
                        })

                    }
                })
                
        
            }) 

        })
    </script>
@endpush