<div class="card" id="timetracker-setting">
    {{ Form::open(['route' => 'timetracker.setting.store', 'enctype' => 'multipart/form-data']) }}

    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('Time Tracker Settings') }}</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="stripe_key" class="form-label">{{ __('') }}</label>
                    {{ Form::label('app_url', __('App Site URL'), ['class' => 'form-label']) }}
                    {{ Form::text('app_url', URL::to('/'), ['class' => 'form-control', 'placeholder' => __('App Site URL'), 'disabled' => 'true']) }}

                    <small>{{ __('App Site URL to login app.') }}</small>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('interval_time', __('Tracking Interval'), ['class' => 'form-label']) }}
                    {{ Form::number('interval_time', company_setting('interval_time'), ['class' => 'form-control', 'placeholder' => __('Enter Tracking Interval'), 'required' => 'required']) }}
                    <small>{{ __('Image Screenshort Take Interval time ( 1 = 1 min)') }}</small>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
    </div>
    {{ Form::close() }}
</div>
