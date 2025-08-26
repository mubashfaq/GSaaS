<div class="card" id="quickbooks-sidenav">
    {{ Form::open(array('route' => 'save.quickbooks.setting','method' => 'post')) }}
    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('QuickBooks Settings') }}</h5>
                <small>Please generate the first token then after you can integrate Quickbooks.</small>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 text-end">
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <a href="{{ route('quickbook.gettoken') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Generate Token') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12a12 12 0 0 0 12-12A12 12 0 0 0 12 0m.642 4.134c.955 0 1.73.775 1.73 1.733v9.066h1.6a2.934 2.934 0 0 0 0-5.866h-.666V7.333h.665A4.663 4.663 0 0 1 20.63 12a4.662 4.662 0 0 1-4.658 4.667h-3.329zM7.984 7.333h3.329v12.533c-.956 0-1.73-.776-1.73-1.733V9.066h-1.6a2.934 2.934 0 0 0 0 5.867h.666v1.733h-.665A4.662 4.662 0 0 1 3.326 12a4.662 4.662 0 0 1 4.658-4.667"/></svg>
                    </a>
                    <input type="checkbox" name="quickbook_is_on" class="form-check-input input-primary" id="quickbook_is_on"
                        {{ (isset($settings['quickbook_is_on']) ? $settings['quickbook_is_on'] : 'off') == 'on' ? ' checked ' : '' }}>
                    <label class="form-check-label" for="quickbook_is_on"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="quickbook-label col-form-label" for="company_quickbook_mode">{{ __('Quickbook Mode') }}</label>
                <br>
                <div class="d-flex">
                    <div class="mr-2">
                        <div class="p-3">
                            <div class="form-check">
                                <label class="form-check-labe text-dark">
                                    <input type="radio" name="company_quickbook_mode" value="sandbox"
                                           class="form-check-input"
                                        {{ !isset($settings['company_quickbook_mode']) || $settings['company_quickbook_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                    {{ __('Sandbox') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mr-2">
                        <div class="p-3">
                            <div class="form-check">
                                <label class="form-check-labe text-dark">
                                    <input type="radio" name="company_quickbook_mode" value="live"
                                           class="form-check-input"
                                        {{ isset($settings['company_quickbook_mode']) && $settings['company_quickbook_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                    {{ __('Live') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="StoreLink" style="display: block">
                    <label for="store_link" class="form-label">QuickBook Webhook link</label>
                    <div class="input-group">
                        <input type="text" value="{{route('quickbook.callback')}}" id="myInput" class="form-control d-inline-block" aria-label="Recipient's username" aria-describedby="button-addon2" readonly="">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="button" onclick="CopyFunction()" id="button-addon2"><i class="far fa-copy"></i>
                                Copy Link</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('quickbook_client_id',__('QuickBooks Client Id'),array('class'=>'form-label')) }}
                    {{Form::text('quickbook_client_id',!empty($settings['quickbook_client_id']) ? $settings['quickbook_client_id'] :'',array('class'=>'form-control quickbookwebhook', 'placeholder' => 'Enter QuickBooks Client Id',(isset($settings['quickbook_is_on']) ? $settings['quickbook_is_on'] : 'off')  == 'on' ? '' : ' disabled'))}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('quickbook_client_secretkey',__('Quickbook Client Secret Key'),array('class'=>'form-label')) }}
                    {{Form::text('quickbook_client_secretkey',!empty($settings['quickbook_client_secretkey']) ? $settings['quickbook_client_secretkey'] :'',array('class'=>'form-control quickbookwebhook', 'placeholder' => 'Enter Quickbook Client Secret Key',(isset($settings['quickbook_is_on']) ? $settings['quickbook_is_on'] : 'off')  == 'on' ? '' : ' disabled'))}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('quickbook_company_id',__('Quickbook Company Id'),array('class'=>'form-label')) }}
                    {{Form::text('quickbook_company_id',!empty($settings['quickbook_company_id']) ? $settings['quickbook_company_id'] :'',array('class'=>'form-control quickbookwebhook', 'placeholder' => 'Enter Quickbook Company Id',(isset($settings['quickbook_is_on']) ? $settings['quickbook_is_on'] : 'off')  == 'on' ? '' : ' disabled'))}}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
    </div>
    {{Form::close()}}
</div>
<script>
    function CopyFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        show_toastr('Success', "Link copied", 'success');
    }
    $(document).on('click', '#quickbook_is_on', function() {
        if ($('#quickbook_is_on').prop('checked')) {
            $(".quickbookwebhook").removeAttr("disabled");
        } else {
            $('.quickbookwebhook').attr("disabled", "disabled");
        }
    });
</script>
