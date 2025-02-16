@extends("admin.layout.app")
@section("title", "Products")
@section("link", route("front.products"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Procuts</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.product.add") }}" class="btn btn-primary">
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
                        <th>Name</th>
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Home</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img style="width:75px" src="{{ asset("uploads/product/") }}/{{ $product->image }}" alt="">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>${{ $product->price }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="checkbox_product_status" 
                                        data-product-id="{{ $product->id }}"
                                        @if($product->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="checkbox_product_home" 
                                        data-product-id="{{ $product->id }}"
                                        @if($product->show_on_homepage == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>                                
                                <a href="{{ route("admin.product.edit",["product_id"=>$product->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-product-id="{{ $product->id }}" href="" class="btn btn-danger product_delete">
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
            $(".checkbox_product_status").change(async function(){

                const el = $(this).closest(".d-inline")
                const product_id =$(this).data("product-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.product.status.update') }}",
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

        /* update */
        $(document).ready(function(){
            $(".checkbox_product_home").change(async function(){

                const el = $(this).closest(".d-inline")
                const product_id =$(this).data("product-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.product.home.update') }}",
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
            $(".product_delete").click(async function(e){
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
                        const product_id =$(this).data("product-id")
                        const formData=new FormData()

                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve, 1000))

                        formData.append("_token", "{{ csrf_token() }}")
                        formData.append("product_id",product_id)

                        $.ajax({
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            url: "{{ route('admin.product.delete') }}",
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