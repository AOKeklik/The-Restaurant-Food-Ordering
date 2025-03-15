@extends("admin.layout.app")
@section("title", "Delivery Areas")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Delivery Areas</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.delivery_area.add") }}" class="btn btn-primary">
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
                        <th>Min</th>
                        <th>Max</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryAreas as $deliveryArea)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $deliveryArea->name }}</td>
                            <td>{{ deliveryTime($deliveryArea->min_time) }}</td>
                            <td>{{ deliveryTime($deliveryArea->max_time) }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="deliveryArea_status" 
                                        data-deliveryArea-id="{{ $deliveryArea->id }}"
                                        @if($deliveryArea->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route("admin.delivery_area.edit",["delivery_area_id"=>$deliveryArea->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-deliveryArea-id="{{ $deliveryArea->id }}" href="" class="btn btn-danger deliveryArea_delete">
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
            $(".deliveryArea_status").change(async function(e){
                
                const el=$(this).closest(".d-inline")
                const status=$(this).prop("checked") ? 1 : 0
                const delivery_area_id=$(this).data("deliveryareaId")
                const formData=new FormData()
                
                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                formData.append("status",status)
                formData.append("delivery_area_id",delivery_area_id)
                formData.append("_token", "{{ csrf_token() }}")
                
                $.ajax({
                    url: "{{ route('admin.delivery_area.ajax.status.update') }}",
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
            $(".deliveryArea_delete").click(async function(e){
                e.preventDefault()

                const tr=$(this).closest("tr")
                const el=$(this)
                const delivery_area_id=$(this).data("deliveryareaId")
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
                        
                        formData.append("delivery_area_id",delivery_area_id)
                        formData.append("_token", "{{ csrf_token() }}")
                        
                        $.ajax({
                            url: "{{ route('admin.delivery_area.ajax.delete') }}",
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