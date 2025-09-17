{{ Form::open(['url' => 'contact-store', 'method' => 'post','class'=>'needs-validation','novalidate', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @include('aiassistant::ai.generate_ai_btn', [
                'template_module' => 'contact',
                'module' => 'Sales',
            ])
        @endif
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
            </div>
        </div>
        @if ($type == 'account')
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                    {!! Form::select('account', $account, $id, ['class' => 'form-control']) !!}
                     <div class=" text-xs">
                    {{ __('Please Add Account. ') }}
                     <a href="{{ route('salesaccount.index') }}"><b>{{ __('Add Account') }}</b></a>
               </div>
                </div>
            </div>
        @else
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                    {!! Form::select('account', $account, null, ['class' => 'form-control']) !!}
                     <div class=" text-xs">
                    {{ __('Please Add Account. ') }}
                     <a href="{{ route('salesaccount.index') }}"><b>{{ __('Add Account') }}</b></a>
               </div>
                </div>
            </div>
        @endif
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <x-mobile label="Phone" name="phone" required="required"></x-mobile>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contactaddress', __('Address'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('contact_address', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => __('Address'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contactaddress', __('City'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('contact_city', null, ['class' => 'form-control', 'id' => 'contact_city' , 'placeholder' => __('City'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contact_postalcode', __('Postal Code'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::number('contact_postalcode', null, ['class' => 'form-control', 'id' => 'contact_postalcode' , 'placeholder' => __('Postal Code'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contactaddress', __('State'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('contact_state', null, ['class' => 'form-control', 'id' => 'contact_state' , 'placeholder' => __('State'), 'required' => 'required']) }}
            </div>
        </div>
        
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contact_country', __('Country'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('contact_country', null, ['class' => 'form-control', 'id' => 'contact_country' , 'placeholder' => __('Country'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('user_id', __('Assign User'), ['class' => 'form-label']) }}
                {!! Form::select('user_id', $user, null, ['class' => 'form-control']) !!}
                <div class=" text-xs">
                    {{ __('Please Add User. ') }}
                     <a href="{{ route('users.index') }}"><b>{{ __('Add User') }}</b></a>
               </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Add Description')]) }}
            </div>
        </div>
        @if (module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="col-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('custom-field::formBuilder')
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Save'), ['class' => 'btn btn-primary ']) }}
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

    // Check if Google Maps is already loaded
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
        try {
            const input = document.getElementById("address");
            if (!input) {
                console.error('Address input element not found');
                return;
            }

            const options = {
                fields: ["formatted_address", "geometry", "name", "address_components"],
                strictBounds: false
            };

            // Initialize Google Places Autocomplete
            const autocomplete = new google.maps.places.Autocomplete(input, options);

            // Add listener for place selection
            autocomplete.addListener("place_changed", function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                try {
                    // Update the address field with the full formatted address
                    document.getElementById('address').value = place.formatted_address;

                    // Initialize city, state, country, and zip variables
                    let city = "", state = "", country = "", zip = "";

                    if (place.address_components) {
                        for (const component of place.address_components) {
                            const types = component.types;
                            if (types.includes("locality")) {
                                city = component.long_name; // City
                            }
                            if (types.includes("administrative_area_level_1")) {
                                state = component.long_name; // State
                            }
                            if (types.includes("country")) {
                                country = component.long_name; // Country
                            }
                            if (types.includes("postal_code")) {
                                zip = component.long_name; // ZIP Code
                            }
                        }
                    } else {
                        console.error('No address components found.');
                    }

                    // Assign values to respective fields
                    if (document.getElementById('contact_city')) document.getElementById('contact_city').value = city;
                    if (document.getElementById('contact_state')) document.getElementById('contact_state').value = state;
                    if (document.getElementById('contact_country')) document.getElementById('contact_country').value = country;
                    if (document.getElementById('contact_postalcode')) document.getElementById('contact_postalcode').value = zip;

                } catch (error) {
                    console.error('Error updating location details:', error);
                }
            });
        } catch (error) {
            console.error('Error initializing Google Places Autocomplete:', error);
        }
    }
</script>

