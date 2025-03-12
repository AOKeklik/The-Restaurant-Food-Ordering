<div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
    <div class="fp_dashboard_body address_body">
        <h3>address <a class="dash_add_new_address"><i class="far fa-plus"></i> add new</a></h3>
        <div class="fp_dashboard_address">
            
            {{-- address --}}
            <div data-section="address-items" class="fp_dashboard_existing_address">
                @include("front.customer-dashboard.address_items_ajax")
            </div>
            
            {{-- address create form --}}
            @include("front.customer-dashboard.address_add_ajax")

            {{-- address edit form --}}
            <div data-section="address-edit-form" class="fp_dashboard_edit_address"></div>

        </div>
    </div>
</div>