<!-- Session Messages -->
@if(Session::has("error"))
<script>
        iziToast.show({
        title: "{{ Session::get("error") }}",
        position: "topRight",
        color: "red"
    })
</script>
@endif
@if(Session::has("success"))
<script>
        iziToast.show({
        title: "{{ Session::get("success") }}",
        position: "topRight",
        color: "green"
    })
</script>
@endif

<script> 
    /* ////////////////////////////////
                Datatable
    // /////////////////////////////// */
    $(document).ready(function () {
        const table = $('#example').DataTable({
            order: [], 
            paging: true, 
            searching: true,
            "paging": true,
        })

        if(table.data().count() === 0) {
            table.destroy()
            $('#example').DataTable({
                order: [], 
                paging: true, 
                searching: true,
                "paging": false,
            })
        }
    })

    /* ////////////////////////////////
                select2
    // /////////////////////////////// */
    $(document).ready(function(){        
        $('.select2').select2({
            placeholder: 'This is my placeholder',
            allowClear: true,
            width: '100%',
        })
    })


    /* ////////////////////////////////
            cart item remove
    // /////////////////////////////// */
    $(document).ready(function(){
        $(document).on("click",".del_icon",async function(e){
            e.preventDefault()

            const product_id=$(this).data("product-id")
            const formData=new FormData()

            formData.append("_token", "{{ csrf_token() }}")
            formData.append("product_id",product_id)

            $(this).closest(".fp__menu_cart_boody").html('<div class="pt-5 d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>')            
            await new Promise(resolve=>setTimeout(resolve,1000))

            
            $.ajax({
                type:"POST",
                contentType:false,
                processData:false,
                data:formData,
                url:"{{ route('front.order.cart.ajax.item.remove') }}",
                success:function(res_1){
                    console.log(res_1)

                    $.ajax({
                        type:"GET",
                        contentType:false,
                        processData:false,
                        url:"{{ route('front.order.cart.ajax.items') }}",
                        success:function(res_2){
                            console.log(res_2)

                            $(".fp__menu_cart_boody").html(res_2)  
                            $(".cart_item_count").html($(".cart_item_count_get").html())

                            iziToast.show({
                                title: res_1.error?.message ?? res_1.success?.message,
                                position: "topRight",
                                color: res_1.error ? "red" : "green"
                            }) 
                        }
                    })
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText) 
                }
            })
        })
    })

    /* ////////////////////////////////
                showup cart popup
    // /////////////////////////////// */
    $(document).ready(function(){
        $(document).on("click",".fp__menu_item .show_up_popup", async function(e){
            e.preventDefault()

            const el = $(this)
            const parent = $(this).closest(".fp__cart_popup")
            const product_id=el.data("product-id")
            const formData=new FormData()

            formData.append("_token", "{{ csrf_token() }}")
            formData.append("product_id",product_id)


            $('.overlay-container').removeClass('d-none');
            $('.overlay').addClass('active');

            await new Promise(resolve=>setTimeout(resolve,1000))

            $.ajax({
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                url:"{{ route('front.order.popup.ajax.submit') }}",
                success:function(res){
                    // console.log(res)
                    
                    $(".load_product_modal_body").html(res)
                    $("#cartModal").modal("show")

                    $('.overlay-container').addClass('d-none');
                    $('.overlay').removeClass('active');
                }
            })

        })
    })
</script>