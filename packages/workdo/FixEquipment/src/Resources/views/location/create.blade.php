{{ Form::open(['route' => 'fix.equipment.location.store', 'class'=>'needs-validation','novalidate','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('Location Name', __('Location Name'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('location_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Location name')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}<x-required></x-required>
{!! Form::textarea('address', old('address'), [
    'class' => 'form-control',
    'rows' => 4,
    'placeholder' => __('Enter Employee Address'),
    'required' => 'required',
    'id' => 'address',
]) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('Attachment', __('Attachment'), ['class' => 'form-label']) }}
                <input type="file" class="form-control" name="attachment">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'rows' => '4']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}
 <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
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
                 console.log("hleoooooo",place);
                if (!place.geometry) {
                    return;
                }

                try {
                    // Extract coordinates
                    // document.getElementById('address_latitude').value = place.geometry.location.lat();
                    // document.getElementById('address_longitude').value = place.geometry.location.lng();
                    document.getElementById('address').value = place.formatted_address;
                    console.log("hleoooooo",place.formatted_address);
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
                    document.getElementById('city').value = city;
                    document.getElementById('state').value = state;
                    document.getElementById('country').value = country;
                    document.getElementById("zipcode").value = zip;
                } catch (error) {
                    console.error('Error updating location details:', error);
                }
            });
        } catch (error) {
            console.error('Error initializing Google Places Autocomplete:', error);
        }
    }
</script>

