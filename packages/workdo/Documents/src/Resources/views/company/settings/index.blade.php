<div class="card" id="documents-sidenav">
    {{ Form::open(['route' => 'document.setting.store', 'method' => 'post' , 'class' => 'needs-validation novalidate']) }}
    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('Documents Settings') }}</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('documents_prefix', __('Documents Prefix'), ['class' => 'form-label']) }}
                    {{ Form::text('documents_prefix', !empty($settings['documents_prefix']) ? $settings['documents_prefix'] : '#DOC', ['class' => 'form-control', 'placeholder' => 'Enter documents Prefix']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
    </div>
    {{ Form::close() }}
</div>
