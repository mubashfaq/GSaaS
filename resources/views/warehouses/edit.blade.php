{{ Form::model($warehouse, array('route' => array('warehouses.update', $warehouse->id), 'method' => 'PUT', 'enctype'=>'multipart/form-data','class' => 'needs-validation', 'novalidate')) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @php
                $templateName = \Workdo\AIAssistant\Entities\AssistantTemplate::where('template_module', 'warehouse')->where('module', 'Pos')->get();
            @endphp
            @if($templateName->isEmpty())
                @include('aiassistant::ai.generate_ai_btn',['template_module' => 'warehouse','module'=>'General'])
            @else
                @include('aiassistant::ai.generate_ai_btn',['template_module' => 'warehouse','module'=>'Pos'])
            @endif
        @endif
    </div>
    <div class="row">
        <div class="form-group col-md-12">

            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required','placeholder' => 'Enter Name')) }}
            @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<x-required></x-required>
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'required' => 'required', 'placeholder' => 'Enter Address'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city',__('City'),array('class'=>'form-label')) }}<x-required></x-required>
            {{Form::text('city',null,array('class'=>'form-control','required' => 'required','placeholder' => 'Enter City'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city_zip',__('Zip Code'),array('class'=>'form-label')) }}<x-required></x-required>
            {{Form::text('city_zip',null,array('class'=>'form-control','required' => 'required','placeholder' => 'Enter Zip Code'))}}
        </div>
        @if(module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="col-md-12 form-group">
                <div class="tab-pane fade show form-label" id="tab-2" role="tabpanel">
                    @include('custom-field::formBuilder',['fildedata' => $warehouse->customField])
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
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
                    if (document.getElementById('city')) document.getElementById('city').value = city;
                    if (document.getElementById('state')) document.getElementById('state').value = state;
                    if (document.getElementById('country')) document.getElementById('country').value = country;
                    if (document.getElementById('city_zip')) document.getElementById('city_zip').value = zip;

                } catch (error) {
                    console.error('Error updating location details:', error);
                }
            });
        } catch (error) {
            console.error('Error initializing Google Places Autocomplete:', error);
        }
    }
</script>