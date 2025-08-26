<div class="container">
    <div class="row">
        <!--<div class="col-lg-12 col-12">-->
        <!--    <div class="vendor-shedule">-->
        <!--        <h4 class="mb-3">{{__('Choose Time Slots')}}</h4>-->
        <!--        <div class="TimeSlot">-->
        <!--            <div class="row">-->
        <!--                @if (!empty($timeSlots))-->
        <!--                    @foreach ($timeSlots as $time)-->
        <!--                        <div class="col-sm-3 col-6">-->
        <!--                            <div class="single time-slot" @if ($time['available']) style="color: red; pointer-events: none;" @endif>-->
        <!--                                <p class="time-slot-text" data-start="{{ $time['start'] }}" data-end="{{ $time['end'] }}">-->
        <!--                                    {{ $time['start'] }} - {{ $time['end'] }}-->
        <!--                                </p>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    @endforeach-->
        <!--                    {{ Form::hidden('start_time', null, ['class' => 'start-time-input']) }}-->
        <!--                    {{ Form::hidden('end_time', null, ['class' => 'end-time-input']) }}-->
        <!--                @else-->
        <!--                    <p>{{ __('No available time slots for the selected date. Please choose another date.') }}</p>-->
        <!--                @endif-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="col-lg-12 col-12">
    <div class="vendor-shedule">
        <h4 class="mb-3">{{__('Choose Time Slots')}}</h4>
        <div class="TimeSlot">
            <div class="row">
                @if (!empty($timeSlots))
                    @foreach ($timeSlots as $time)
                        <div class="col-sm-3 col-6">
                            <div class="single time-slot" @if (!$time['available']) style="color: #999; pointer-events: none; opacity: 0.7;" @endif>
                                <p class="time-slot-text" data-start="{{ $time['start'] }}" data-end="{{ $time['end'] }}">
                                    {{ $time['start'] }} - {{ $time['end'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    {{ Form::hidden('start_time', null, ['class' => 'start-time-input']) }}
                    {{ Form::hidden('end_time', null, ['class' => 'end-time-input']) }}
                @else
                    <p>{{ __('No available time slots for the selected date. Please choose another date.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
        <div class="col-lg-12 col-12 mt-2">
            <div class="row">
                <h4>{{'Your Location'}}</h4>
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('your_address', __('Address'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::text('your_address',isset($appointment->your_address) ? $appointment->your_address : '', ['class' => 'form-control ','placeholder'=> 'Enter Address' , 'required' => 'required']) }}
                </div>
               
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('your_state', __('State'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::text('your_state',isset($appointment->your_state) ? $appointment->your_state : '', ['class' => 'form-control ','placeholder'=> 'Enter State' , 'required' => 'required']) }}
                </div>
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('your_city', __('City'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::text('your_city',isset($appointment->your_city) ? $appointment->your_city : '', ['class' => 'form-control ','placeholder'=> 'Enter City' , 'required' => 'required']) }}
                </div>
                
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('your_zip_code', __('Zip code'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::number('your_zip_code',isset($appointment->your_zip_code) ? $appointment->your_zip_code : '', ['class' => 'form-control ','placeholder'=> 'Enter Zip code' , 'required' => 'required']) }}
                </div>
                 <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('your_country', __('Country'),['class'=>'col-form-label']) }}<x-required></x-required>
                    {{ Form::text('your_country', isset($appointment->your_country) ? $appointment->your_country :'', ['class' => 'form-control','placeholder'=> 'Enter Country' ,'required'=>'required']) }}
                </div>
            </div>
            <br>
            @php
                $settings = getCompanyAllSetting();
            @endphp
            <div class="row">
                <h4>{{'Our Location'}}</h4>
                
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('our_state', __('State'), ['class' => 'col-form-label']) }}
                    {{ Form::text('our_state',isset($settings['bookings_our_state']) ? $settings['bookings_our_state'] :'', ['class' => 'form-control ','placeholder'=> 'Enter State' , 'required' => 'required', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('our_city', __('City'), ['class' => 'col-form-label']) }}
                    {{ Form::text('our_city',isset($settings['bookings_our_city']) ? $settings['bookings_our_city'] :'', ['class' => 'form-control ','placeholder'=> 'Enter City' , 'required' => 'required', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('our_zip_code', __('Zip code'), ['class' => 'col-form-label']) }}
                    {{ Form::number('our_zip_code',isset($settings['bookings_our_zip_code']) ? $settings['bookings_our_zip_code'] :'', ['class' => 'form-control ','placeholder'=> 'Enter Zip code' , 'required' => 'required', 'readonly' => 'readonly']) }}
                </div>
                <div class="form-group col-md-6 col-12 mb-3">
                    {{ Form::label('our_country', __('Country'),['class'=>'col-form-label']) }}
                    {{ Form::text('our_country', isset($settings['bookings_our_country']) ? $settings['bookings_our_country'] :'', ['class' => 'form-control','placeholder'=> 'Enter Country' ,'required'=>'required', 'readonly' => 'readonly']) }}
                </div>
            </div>
            <br>
            <div class="row">
                <h4>{{'Summary'}}</h4>
                <div class="row d-flex align-items-center">
                    <div class="col-auto">
                        <h6>{{__('Date')}}</h6>
                        <p class="m-0">{{ $formattedSelectedDate }}</p>
                    </div>
                    <div class="col-auto">
                        <h6>{{__('Time')}}</h6>
                        <p class="m-0" id="selected-time-slot">{{ ('No time selected') }}</p>
                    </div>
                    <div class="col-auto">
                        <h6>{{__('Price')}}</h6>
                        <p class="m-0">{{ currency_format_with_sym($serivceID->price) ?? '-' }}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="text-end mt-3">
        {{ Form::submit('Book Now', ['id' => 'submitBtn', 'class' => 'btn btn-primary']) }}
    </div>
</div>


<script>
    $(document).ready(function() {
        $(".single").click(function() {
            $(".single").removeClass("selected");
            $(this).addClass("selected");
        });
    });
</script>

<script>
  $(document).ready(function() {
        // Fix duplicate ready functions
        $('.time-slot').on('click', function() {
            $('.time-slot').removeClass('active');
            $(this).addClass('active');
            var startTime = $(this).find('.time-slot-text').data('start');
            var endTime = $(this).find('.time-slot-text').data('end');
            $('.start-time-input').val(startTime);
            $('.end-time-input').val(endTime);
            
            console.log('Selected time: ' + startTime + ' - ' + endTime);
        });
        
        // Handle form submission
        $('#bookingForm').submit(function(event) {
            var startTime = $('.start-time-input').val();
            var endTime = $('.end-time-input').val();
            
            // Validate if time slot is selected
            if (!startTime || !endTime) {
                event.preventDefault();
                alert('Please select a time slot');
                return false;
            }
        });
    });
    // $(document).ready(function() {
    //     $(document).ready(function() {
    //         $('.time-slot').on('click', function() {
    //             $('.time-slot').removeClass('active');
    //             $(this).addClass('active');

    //             var startTime = $(this).find('.time-slot-text').data('start');
    //             var endTime = $(this).find('.time-slot-text').data('end');

    //             $('.start-time-input').val(startTime);
    //             $('.end-time-input').val(endTime);
    //         });
    //     });

    //     // Handle form submission
    //     $('#bookingForm').submit(function(event) {
    //         event.preventDefault();

    //         var startTime = $('.start-time-input').val();
    //         var endTime = $('.end-time-input').val();

    //         $(this).unbind('submit').submit();
    //     });
    // });
</script>

<script>
    $(document).ready(function() {
    $('.time-slot-text').on('click', function() {
      var startTime = $(this).data('start');
      var endTime = $(this).data('end');

      var selectedTime = startTime + ' - ' + endTime;

      $('.start-time-input').val(startTime);
      $('.end-time-input').val(endTime);

      $('#selected-time-slot').text(selectedTime);

      $('.time-slot-text').removeClass('selected');
      $(this).addClass('selected');
    });
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
<style>
    .time-slot {
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .time-slot:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
    
    .time-slot.active {
        background-color: #007bff;
        color: white !important;
        border-color: #007bff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .time-slot-text {
        margin: 0;
        text-align: center;
        font-weight: 500;
    }
</style>
<style>
    .pac-container {
    z-index: 9999;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

