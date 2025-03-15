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
                DATATABLE
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
                SELECT2
    // /////////////////////////////// */
    $(document).ready(function(){        
        $('.select2').select2({
            placeholder: 'This is my placeholder',
            allowClear: true,
            width: '100%',
        })
    })

    /* ////////////////////////////////
            TOGGLE CART SIDEBAR
    // /////////////////////////////// */
    $(document).ready(function(){
        $(document)
            .on("click",".cart_icon",showCartSideBar)
            .on("click",".close_cart",hideCartSideBar)

        function showCartSideBar(){
            $(".fp__menu_cart_area").addClass("show_mini_cart")
        }

        function hideCartSideBar(){
            $(".fp__menu_cart_area").removeClass("show_mini_cart")
        }
    })
        

    /* ////////////////////////////////
            CART ITEM REMOVE
    // /////////////////////////////// */
    $(document).ready(function(){
        $(document).on("click",".del_icon",async function(e){
            e.preventDefault()

            const product_id=$(this).data("product-id")
            const formData=new FormData()

            formData.append("_token", "{{ csrf_token() }}")
            formData.append("product_id",product_id)
            formData.append("current_url",window.location.href)
            

            showLoadingSpinner("cart")           
            await delay(1000)
            
            removeCartItem(formData)
        })

        function removeCartItem (formData) {
            $.ajax({
                type:"POST",
                contentType:false,
                processData:false,
                data:formData,
                url:"{{ route('front.order.cart.ajax.item.remove') }}",
                success: async res => {
                    // console.log(res)

                    await redirect(res)
                    fetchCartSidebar()
                    fetchCheckoutPage()
                    fetchCartCount()
                    fetchCartPage()
                    showNotification(res)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText) 
                }
            })
        }

        function fetchCartSidebar(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.cart.ajax.items') }}",
                success:function(cartItems){
                    $("[data-section-cart=sidebar-items]").html(cartItems)
                }
            })
        }

        function fetchCartPage(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.cart.ajax.page') }}",
                success:function(cartItemsPage){
                    $("[data-section-cart=page]").html(cartItemsPage) 
                }
            })
        }

        function fetchCheckoutPage(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.checkout.view.ajax.page') }}",
                success:function(res){
                    $("[data-section=checkout-page]").html(res)
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }

        function fetchCartCount(){
            $.ajax({
                type:"GET",
                url:"{{ route('front.order.cart.ajax.count') }}",
                success:function(count){
                    $("[data-section-cart=count]").html(count) 
                }
            })
        }

        function showLoadingSpinner(section){
            $("[data-section-spinner="+section+"]").html('<div class="pt-5 d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>') 
        }

        function delay(ms){
            return new Promise(resolve=>setTimeout(resolve,ms))
        }

        function showNotification(res){
            iziToast.show({
                title: res.error?.message ?? res.success?.message,
                position: "topRight",
                color: res.error ? "red" : "green"
            }) 
        }

        function redirect(res){
            console.log(res)
            if(res.redirect)
                window.location.href=res.redirect.link
        }
    })

    /* ////////////////////////////////
            SHOW UP CART POPUP
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

            showOverlay()
            await delay(1000)

            submitPopupForm(formData)
        })

        function submitPopupForm(formData) {
            $.ajax({
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                url:"{{ route('front.order.popup.ajax.submit') }}",
                success:function(res){
                    // console.log(res)
                    
                    showProductModal(res)
                    hideOverlay()
                },
                error: function(xhr) {
                    console.error(xhr.responseText)
                    hideOverlay()
                }
            })
        }

        function showProductModal(res){
            $(".load_product_modal_body").html(res)
            $("#cartModal").modal("show")
        }

        function showOverlay(){
            $('.overlay-container').removeClass('d-none');
            $('.overlay').addClass('active');
        }

        function hideOverlay(){
            $('.overlay-container').addClass('d-none');
            $('.overlay').removeClass('active');
        }

        function delay(ms){
            return new Promise(resolve=>setTimeout(resolve,ms))
        }
    })
</script>