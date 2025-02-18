@extends("admin.layout.app")
@section("title", "Product Gallery")
@section("link", route("front.products"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Images</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.products") }}" class="btn btn-primary">
                Products
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <form class="col-md-8" action="{{ route("admin.product.image.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <input type="hidden" name="product_id" value="{{ request("product_id") }}">
                <!-- Image Upload -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <img src="https://placehold.co/300x150?text=Hello\nWorld" alt="" class="w-100">
                    </div>
                    <div class="col-md-6">
                        <label for="images" class="form-label">Image*</label>
                        <input name="images[]" type="file" class="form-control" id="images" multiple>
                        @error("images") <small class="text-danger">{{ $message }}</small> @enderror
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
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($images as $image)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img style="width:75px" src="{{ asset("uploads/product-image") }}/{{ $image->image }}" alt="">
                            </td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="image_status" 
                                        data-product-id="{{ request("product_id") }}"
                                        data-image-id="{{ $image->id }}"
                                        @if($image->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>                                
                                <label for="image-{{ $image->id }}" class="btn btn-primary">
                                    <span class="button-loader"></span>
                                    <input data-image-id="{{ $image->id }}" data-product-id="{{ request("product_id") }}" type="file" name="image" id="image-{{ $image->id }}" class="d-none image">
                                    <i class="fas fa-edit"></i>
                                </label>
                                <a data-image-id="{{ $image->id }}" data-product-id="{{ request("product_id") }}" href="" class="btn btn-danger image_delete">
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
        /* files */
        $(document).ready(function(){
            $("#images").change(function(e){
                const images = []

                Array.from(e.target.files).forEach(file => {
                    images.push(`
                        <div class="col-md-4">
                            <img src='${URL.createObjectURL(file)}' class='w-100'>
                        </div>
                    `)
                })


                $(this).closest("form").find(".col-md-6").first().html("")
                $(this).closest("form").find(".col-md-6").first().html(`
                    <div class="row">
                        ${images.join("")}
                    </div>
                `)
            })
        })

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
            $(".image_status").change(async function(){

                const el = $(this).closest(".d-inline")
                const product_id =$(this).data("product-id")
                const image_id =$(this).data("image-id")
                const status = $(this).prop("checked") ? 1 : 0
                const formData=new FormData()

                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve, 1000))

                formData.append("_token", "{{ csrf_token() }}")
                formData.append("product_id",product_id)
                formData.append("image_id",image_id)
                formData.append("status",status)

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: "{{ route('admin.product.image.status.update') }}",
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

        /* delete image */
        $(document).ready(function(){
            $(".image_delete").click(function(e){
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
                        const image_id =$(this).data("image-id")
                        const product_id =$(this).data("product-id")
                        const formData=new FormData()

                        el.addClass("pending")
                        el.removeClass("active")
                        await new Promise(resolve=>setTimeout(resolve, 1000))

                        formData.append("_token", "{{ csrf_token() }}")
                        formData.append("product_id",product_id)
                        formData.append("image_id",image_id)

                        $.ajax({
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formData,
                            url: "{{ route('admin.product.image.delete') }}",
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