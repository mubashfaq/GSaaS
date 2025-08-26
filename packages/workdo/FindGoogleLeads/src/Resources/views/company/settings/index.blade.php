<div class="card" id="findgooglelead-sidenav">
    {{ Form::open(['route' => 'findgooglelead.setting.save', 'method' => 'post']) }}
    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('Find Google Leads Settings') }}</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('findgoogleleads_api_key', __('API Key'), ['class' => 'form-label']) }}
                    {{ Form::text('findgoogleleads_api_key', !empty($settings['findgoogleleads_api_key']) ? $settings['findgoogleleads_api_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter API Key')]) }}

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('finsgoogleleads_radius', __('Radius'), ['class' => 'form-label']) }}
                    {{ Form::number('finsgoogleleads_radius', !empty($settings['finsgoogleleads_radius']) ? $settings['finsgoogleleads_radius'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Radius (in meters) that will be used to search e.g 1000
                    ')]) }}

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('finsgoogleleads_pipelines', __('Select Pipline'), ['class' => 'form-label']) }}
                    {{ Form::select('finsgoogleleads_pipelines', $pipelines,!empty($settings['finsgoogleleads_pipelines']) ? $settings['finsgoogleleads_pipelines'] : null , ['class' => 'form-control'] ,['id'=>'finsgoogleleads_pipelines']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('finsgoogleleads_lead_stages', __('Select Stages'), ['class' => 'form-label']) }}
                    {{ Form::select('finsgoogleleads_lead_stages', $lead_stages,!empty($settings['finsgoogleleads_lead_stages']) ? $settings['finsgoogleleads_lead_stages'] : null, ['class' => 'form-control'],['id'=>'lead_stages']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
    </div>
    {{ Form::close() }}

</div>
<script>
    $(document).ready(function() {
        $('#finsgoogleleads_pipelines').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{ route('findgooglelead.setting.get.stage') }}',
                method: 'POST',
                data: { 'id': id },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 1) {
                        var options = result.data;
                        var selectOptions = '';
                        for (var key in options) {
                            selectOptions += '<option value="' + key + '">' + options[key] + '</option>';
                        }
                        $('#finsgoogleleads_lead_stages').empty().html(selectOptions);
                    } else {
                        toastrs('error', '{{__('No lead stages found for this pipeline.')}}', 'error')
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>





