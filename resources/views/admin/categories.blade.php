@extends("admin.layout.app")
@section("title", "Categories")
@section("link", route("front.index"))
@section("content")
<div class="card">
    <div class="card-header">
        <h4>Card Category</h4>
        <div class="card-header-action">
            <a href="{{ route("admin.category.add") }}" class="btn btn-primary">
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
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Home Page</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="status" 
                                        data-category-id="{{ $category->id }}"
                                        @if($category->status == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <div class="d-inline active">
                                    <span class="button-loader"></span>
                                    <input 
                                        type="checkbox"
                                        class="show_on_homepage" 
                                        data-category-id="{{ $category->id }}"
                                        @if($category->show_on_homepage == 1) checked @endif
                                        data-toggle="toggle" data-onlabel="On" data-offlabel="Off" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route("admin.category.edit",["category_id"=>$category->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a data-category-id="{{ $category->id }}" href="" class="btn btn-danger category_delete">
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
            $(".status").change(async function(e){
                
                const el=$(this).closest(".d-inline")
                const status=$(this).prop("checked") ? 1 : 0
                const category_id=$(this).data("category-id")
                const formData=new FormData()

                
                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                formData.append("status",status)
                formData.append("category_id",category_id)
                formData.append("_token", "{{ csrf_token() }}")
                
                $.ajax({
                    url: "{{ route('admin.category.status.update') }}",
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

            /* update home status */
            $(".show_on_homepage").change(async function(e){
                
                const el=$(this).closest(".d-inline")
                const show_on_homepage=$(this).prop("checked") ? 1 : 0
                const category_id=$(this).data("category-id")
                const formData=new FormData()

                
                el.addClass("pending")
                el.removeClass("active")
                await new Promise(resolve=>setTimeout(resolve,1000))
                
                formData.append("show_on_homepage",show_on_homepage)
                formData.append("category_id",category_id)
                formData.append("_token", "{{ csrf_token() }}")
                
                $.ajax({
                    url: "{{ route('admin.category.home.update') }}",
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
            $(".category_delete").click(async function(e){
                e.preventDefault()

                const tr=$(this).closest("tr")
                const el=$(this)
                const category_id=$(this).data("category-id")
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
                        
                        formData.append("category_id",category_id)
                        formData.append("_token", "{{ csrf_token() }}")
                        
                        $.ajax({
                            url: "{{ route('admin.category.delete') }}",
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