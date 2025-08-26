{{ Form::open(array('route' => array('booking-appointments.store'),'enctype' => 'multipart/form-data','class'=>'needs-validation','novalidate')) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('date'  , null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Date','id'=>'date', 'min' => date('Y-m-d')]) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('service', __('Service'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('service' , $service ,null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Service','id'=>'service']) }}
           <div class="text-xs">
            {{ __('Please add Service. ') }}
            <a href="{{ url('bookings/booking-items') }}"><b>{{ __('Add Service') }}</b></a>
            </div>
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('package', __('Package'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('package',[],null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Package','id'=>'package']) }}
             <div class="text-xs">
            {{ __('Please add Package. ') }}
            <a href="{{ url('bookings/booking-package') }}"><b>{{ __('Add Package') }}</b></a>
            </div>
            
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('customer', __('Customer'), ['class' => 'form-label']) }}
                <select class="form-control select_person_email {{ !empty($errors->first('client_name')) ? 'is-invalid' : '' }}" name="client_id"  id="customer">
                    <option value="">{{ __('Select Client') }}</option>
                    @foreach ($customers as $id => $customer)
                        <option value="{{ $customer->id }}">
                            {{ !empty($customer->client_id) ? $customer->client->name : $customer->name }}
                        </option>
                    @endforeach
                </select>
                
                <div class="text-xs">
            {{ __('Please add Customer. ') }}
            <a href="{{ url('bookings/booking-customers') }}"><b>{{ __('Add Customer') }}</b></a>
            </div>
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('staff', __('Staff'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('staff' , $staff ,null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Staff', 'id' => 'staff']) }}
           <div class="text-xs">
            {{ __('Please add Staff. ') }}
            <a href="{{ url('bookings/booking-staff') }}"><b>{{ __('Add Staff') }}</b></a>
            </div>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-warning" id="searchBtn" type="button">{{ __('Choose Slot') }}</button>
            </div>
            <section class="VendorDetails mt-2" id="append_div">
            </section>
        </div>
    <div>
{{ Form::close() }}

<script type="text/javascript">
    $('#service').on('change', function() {
        var serviceId = $(this).val();
        if(serviceId) {
            $.ajax({
                url: "{{ route('package.service') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    serviceId: serviceId
                },
                success: function(data) {
                    
                    $('#package').empty();
                    $('#package').append('<option value="">Enter Package</option>');
                    $.each(data, function(key, value) {
                        $('#package').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                },

            });
        } else {
            $('#package').empty();
            $('#package').append('<option value="">Enter Package</option>');
        }
    });
</script>


<script>
    document.getElementById('your_address').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            return false;
        }
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
            const input = document.getElementById("your_address");
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
                    // Extract coordinates
                    // document.getElementById('address_latitude').value = place.geometry.location.lat();
                    // document.getElementById('address_longitude').value = place.geometry.location.lng();
                    document.getElementById('your_address').value = place.formatted_address;

                    // Initialize city, state, and country variables
                    let city = "", state = "", country = "",zip = "";;

                    // Check if address_components is available
                    if (place.address_components) {
                        // Loop through address_components to find city, state, and country
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

                    // Update the company_city input dynamically
                    // document.getElementById('company_city').value = city;

                    // Assign values to hidden fields
                    document.getElementById('your_city').value = city;
                    document.getElementById('your_state').value = state;
                    document.getElementById('your_country').value = country;
                    document.getElementById("your_zip_code").value = zip;
                } catch (error) {
                    console.error('Error updating location details:', error);
                }
            });
        } catch (error) {
            console.error('Error initializing Google Places Autocomplete:', error);
        }
    }
</script>


