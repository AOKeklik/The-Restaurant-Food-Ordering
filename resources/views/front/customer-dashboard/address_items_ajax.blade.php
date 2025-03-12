<div class="row">
    @foreach($addresses as $address)
        <div class="col-md-6">
            <div class="fp__checkout_single_address">
                <div class="form-check">
                    <label class="form-check-label">
                        <span class="icon">
                            @if($address->type == "home") <i class="fas fa-home"></i> 
                            @else <i class="fas fa-car-building"></i> 
                            @endif
                            {!! $address->type !!}
                        </span>
                        <span class="address">{!! $address->address !!} ({{ $address->deliveryArea->name }})</span>
                    </label>
                </div>
                <ul>
                    <li><a data-btn="address-edit" data-address-id="{{ $address->id }}" class="dash_edit_btn"><i class="far fa-edit"></i></a></li>
                    <li><a data-btn="address-delete" data-address-id="{{ $address->id }}" class="dash_del_icon"><i class="fas fa-trash-alt"></i></a></li>
                </ul>
            </div>
        </div>
    @endforeach
</div>