@extends("admin.layout.app")
@section("title", "Product Sizes")
@section("link", route("front.products"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Sizes</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.products") }}" class="btn btn-primary">
                Products
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.product.size.store") }}" method="POST">
                @csrf
                @method("POST")
                <input type="hidden" name="product_id" value="{{ request("product_id") }}">
                <!-- Image Upload -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ old("name") }}">
                        @error("name") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price*</label>
                        <input name="price" type="text" class="form-control" id="price"  value="{{ old("price") }}">
                        @error("price") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
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
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sizes as $size)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $size->name }}</td>
                            <td>{{ currency($size->price) }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="size_status" 
                                        data-product-id="{{ request("product_id") }}"
                                        data-size-id="{{ $size->id }}"
                                        @if($size->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>    
                                <a href="{{ route("admin.product.size.edit",["size_id"=>$size->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>   
                                <a data-size-id="{{ $size->id }}" data-product-id="{{ request("product_id") }}" href="" class="btn btn-danger size_delete">
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
            $(".image").change(async function(e){

                const el = $(this)
                const parent = $(this).closest("label")
                const product_id =$(this).data("product-id")
                const image_id =$(this).data("image-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                parent.addClass("pending")
                parent.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("image",e.target.files[0])
                formData.append("product_id",product_id)
                formData.append("image_id",image_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.product.image.update') }}",
                    success:function(res){
                        console.log(res)

                        iziToast.show({
                            title: res.error?.message ?? res.success?.message,
                            color: res.error ? "red" : "green",
                            position: "topRight",
                        })

                        if(res.success)
                            el.closest("tr").find("img").attr("src", URL.createObjectURL(e.target.files[0]))


                        parent.removeClass("pending")
                        parent.addClass("active")
                    }
                })
            })
        })

        /* update */
        $(document).ready(function(){
            $(".size_status").change(async function(){

                const el = $(this).closest(".d-inline")
                const product_id =$(this).data("product-id")
                const size_id =$(this).data("size-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("size_id",size_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.product.size.status.update') }}",
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

        /* delete size */
        $(document).ready(function(){
            $(".size_delete").click(function(e){
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
                        const size_id =$(this).data("size-id")
                        const product_id =$(this).data("product-id")
                        const formData=new FormData()

                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve, 1000))

                        formData.append("_token", "{{ csrf_token() }}")
                        formData.append("product_id",product_id)
                        formData.append("size_id",size_id)

                        $.ajax({
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            url: "{{ route('admin.product.size.delete') }}",
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
                })
            })
        })
    </script>
@endpush