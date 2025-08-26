{{ Form::open(['url' => 'customer', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class'=>'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <h5 class="sub-title  mb-3">{{ __('Basic Info') }}</h5>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Name']) }}
            </div>
        </div>
        <x-mobile divClass="col-lg-4 col-md-4 col-sm-6" name="contact" label="{{ __('Contact') }}"
            placeholder="{{ __('Enter Contact') }}" id="contact" required>
        </x-mobile>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Email']) }}
            </div>
        </div>
        @stack('electronic_address')
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::password('password', ['class' => 'form-control', 'required' => 'required', 'minlength' => '6', 'placeholder' => 'Enter Password']) }}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('tax_number', __('Tax Number'), ['class' => 'form-label']) }}
                    {{ Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => 'Enter ACN/ABN']) }}
            </div>
        </div>
        @if (module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="col-md-12">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('custom-field::formBuilder')
                </div>
            </div>
        @endif
    </div>

    <h5 class="sub-title mb-3">{{ __('Billing Address') }}</h5>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_name', __('Name'), ['class' => '', 'class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::text('billing_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <x-mobile divClass="col-lg-6 col-md-6  col-sm-6" name="billing_phone" label="{{ __('Phone') }}"
            placeholder="{{ __('Enter Phone') }}" id="billing_phone" required>
        </x-mobile>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('billing_address', __('Address'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="input-group">
                    {{ Form::textarea('billing_address', null, ['class' => 'form-control', 'id'=>'address', 'rows' => 3, 'placeholder' => __('Enter Address'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_city', __('City'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::text('billing_city', null, ['class' => 'form-control', 'placeholder' => __('Enter City'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_zip', __('Zip Code'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::text('billing_zip', null, ['class' => 'form-control', 'placeholder' => __('Enter Zip Code'), 'required' => 'required']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_state', __('State'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::text('billing_state', null, ['class' => 'form-control', 'placeholder' => __('Enter State'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_country', __('Country'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::text('billing_country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
       
    </div>
    @if (company_setting('invoice_shipping_display') == 'on' || company_setting('proposal_shipping_display') == 'on' )
        <div class="col-md-12 text-end mb-2">
            <a href="#" id="billing_data" value="" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Shipping Same As Billing') }}"><i class="ti ti-copy"></i></a>
        </div>
        <h6 class="sub-title">{{ __('Shipping Address') }}</h6>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_name', __('Name'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name')]) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_phone', __('Phone'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_phone', null, ['class' => 'form-control', 'placeholder' => __('Enter Phone')]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('shipping_address', __('Address'), ['class' => 'form-label']) }}
                    <label class="form-label" for="example2cols1Input"></label>
                    <div class="input-group">
                        {{ Form::textarea('shipping_address', null, ['class' => 'form-control', 'id'=>'shipping_address', 'rows' => 3, 'placeholder' => __('Enter Address')]) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_city', __('City'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_city', null, ['class' => 'form-control', 'placeholder' => __('Enter City')]) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_state', __('State'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_state', null, ['class' => 'form-control', 'placeholder' => __('Enter State')]) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_country', __('Country'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country')]) }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_zip', __('Zip Code'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_zip', null, ['class' => 'form-control', 'placeholder' => __('Enter Zip Code')]) }}
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<style>
    .pac-container {
    z-index: 9999;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

<script>
    document.querySelectorAll("input, textarea").forEach(input => {
        input.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    });

    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
    window.googleMapsInitialized = false;

    window.initMap = function() {
        if (window.googleMapsInitialized) return;
        window.googleMapsInitialized = true;
        initializeAutocomplete();
    };

    if (!document.querySelector('script[src*="maps.googleapis.com/maps/api/js"]')) {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyB7aLtWqhztn7r4Fcce7WqQT-Qdlpl7MnQ&libraries=places&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            console.error('Failed to load Google Maps API');
        };
        document.head.appendChild(script);
    }
} else {
    initializeAutocomplete();
}

function initializeAutocomplete() {
    // Common options for both autocompletes
    const options = {
        fields: ["formatted_address", "geometry", "name", "address_components"],
        strictBounds: false
    };

    // Initialize billing address autocomplete
    const billingInput = document.getElementById("address");
    if (billingInput) {
        const billingAutocomplete = new google.maps.places.Autocomplete(billingInput, options);
        billingAutocomplete.addListener("place_changed", function() {
            const place = billingAutocomplete.getPlace();
            if (!place.geometry) return;

            try {
                document.getElementById('address').value = place.formatted_address;
                let city = "", state = "", country = "", zip = "";

                if (place.address_components) {
                    for (const component of place.address_components) {
                        const types = component.types;
                        if (types.includes("locality")) {
                            city = component.long_name;
                        }
                        if (types.includes("administrative_area_level_1")) {
                            state = component.long_name;
                        }
                        if (types.includes("country")) {
                            country = component.long_name;
                        }
                        if (types.includes("postal_code")) {
                            zip = component.long_name;
                        }
                    }
                }

                if (document.getElementById('billing_city')) document.getElementById('billing_city').value = city;
                if (document.getElementById('billing_state')) document.getElementById('billing_state').value = state;
                if (document.getElementById('billing_country')) document.getElementById('billing_country').value = country;
                if (document.getElementById('billing_zip')) document.getElementById('billing_zip').value = zip;
            } catch (error) {
                console.error('Error updating billing location details:', error);
            }
        });
    }

    // Initialize shipping address autocomplete
    const shippingInput = document.getElementById("shipping_address");
    if (shippingInput) {
        const shippingAutocomplete = new google.maps.places.Autocomplete(shippingInput, options);
        shippingAutocomplete.addListener("place_changed", function() {
            const place = shippingAutocomplete.getPlace();
            if (!place.geometry) return;

            try {
                document.getElementById('shipping_address').value = place.formatted_address;
                let city = "", state = "", country = "", zip = "";

                if (place.address_components) {
                    for (const component of place.address_components) {
                        const types = component.types;
                        if (types.includes("locality")) {
                            city = component.long_name;
                        }
                        if (types.includes("administrative_area_level_1")) {
                            state = component.long_name;
                        }
                        if (types.includes("country")) {
                            country = component.long_name;
                        }
                        if (types.includes("postal_code")) {
                            zip = component.long_name;
                        }
                    }
                }

                if (document.getElementById('shipping_city')) document.getElementById('shipping_city').value = city;
                if (document.getElementById('shipping_state')) document.getElementById('shipping_state').value = state;
                if (document.getElementById('shipping_country')) document.getElementById('shipping_country').value = country;
                if (document.getElementById('shipping_zip')) document.getElementById('shipping_zip').value = zip;
            } catch (error) {
                console.error('Error updating shipping location details:', error);
            }
        });
    }
}
</script>

