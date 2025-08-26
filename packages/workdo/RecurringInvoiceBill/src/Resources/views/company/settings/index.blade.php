<div class="card" id="sidenav-recurringinvoicebill">
    {{ Form::open(['route' => 'recurring.setting.store', 'method' => 'post']) }}
<div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('Recurring Invoice & Bill Settings') }}</h5>
            </div>
        </div>
    </div>
    <div class="card-body pb-0">
            <div class="col-12 row form-group">
                <div class="col-md-6">
                    <label for="recurring_invoice_bill">{{ __('Recurring Invoice & Bill Settings') }}</label>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch  float-end">
                        <input type="checkbox" name="recurring_invoice_bill"
                            class="form-check-input input-primary pointer" value="on" id="recurring_invoice_bill"
                            {{ isset($settings['recurring_invoice_bill']) && $settings['recurring_invoice_bill'] == 'on' ? ' checked ' : '' }}>
                        <label class="form-check-label" for="recurring_invoice_bill"></label>
                    </div>
                </div>
            </div>
            <small class="col-md-10">{{__('Note: With the recurring invoices button enabled in settings, easily customize the duplication frequency using the custom button. Choose the desired interval for invoice duplication or set it to infinity for seamless management of recurring billing cycles.')}}</small><br><br>
            <div class="font-bold">{{__('Recurring Invoice & Bill Cronjob Instruction')}}</div>
            <small>{{__('1. If you would like to create automatically Recurring Invoice and Bill you need set a cron job for that which one run like every day.')}}</small><br>
            <small>{{__('0 0 * * *domain && php artisan recurring:invoice-bill >/dev/null 2>&1')}}</small><br>
            <small>{{__('2. Example url as  ' . '/usr/local/bin/ea-php82 /home/proje99/public_html/dash-demo.workdo.io/artisan recurring:invoice-bill')}}</small><br><br>


    </div>

    <div class="card-footer">
        <div class="text-end">
            <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
        </div>
    </div>
    {{ Form::close() }}

</div>
