{{ Form::open(['url' => 'call', 'method' => 'post', 'class'=>'needs-validation','novalidate','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @include('aiassistant::ai.generate_ai_btn', ['template_module' => 'call', 'module' => 'Sales'])
        @endif
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }} <x-required></x-required>
                {!! Form::select('status', $status, null, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Select Status',
                ]) !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                {!! Form::date('start_date', date('Y-m-d'), [
                    'class' => 'form-control',
                    'placeholder' => 'Start Date',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                {!! Form::date('end_date', date('Y-m-d'), [
                    'class' => 'form-control',
                    'placeholder' => 'End Date',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('direction', __('Direction'), ['class' => 'form-label']) }}
                {!! Form::select('direction', $direction, null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>
        <div class="col-6" data-name="parent">
            <div class="form-group">
                {{ Form::label('parent', __('Parent'), ['class' => 'form-label']) }} <x-required></x-required>
                {!! Form::select('parent', $parent, null, [
                    'class' => 'form-control',
                    'name' => 'parent',
                    'id' => 'parent',
                    'placeholder' => 'Select Parent',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        <div class="col-6" data-name="parent">
            <div class="form-group">
                {{ Form::label('parent_id', __('Parent User'), ['class' => 'form-label']) }} <x-required></x-required>
                <select class="form-control" name="parent_id" id="parent_id" required="">

                </select>
            </div>
        </div>
        @if ($type == 'account')
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('account', __('Account Name'), ['class' => 'form-label']) }} <x-required></x-required>
                    {!! Form::select('account', $account_name, $id, [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Account',
                    ]) !!}
                    <div class=" text-xs">
                            {{ __('Please create Account.') }}
                             <a href="{{ route('salesaccount.index') }}"><b>{{ __('Create Account') }}</b></a>
                       </div>
                </div>
            </div>
        @else
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('account', __('Account'), ['class' => 'form-label']) }} <x-required></x-required>
                    {!! Form::select('account', $account_name, null, [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Select Account',
                    ]) !!}
                    <div class=" text-xs">
                            {{ __('Please create Account.') }}
                             <a href="{{ route('salesaccount.index') }}"><b>{{ __('Create Account') }}</b></a>
                       </div>
                </div>
            </div>
        @endif
        <div class="col-12 ">
            <div class="form-group">
                {{ Form::label('user', __('Assign User'), ['class' => 'form-label']) }} <x-required></x-required>
                {!! Form::select('user', $user, null, [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => __('Select Assign User'),
                ]) !!}
                <div class=" text-xs">
                            {{ __('Please create User.') }}
                             <a href="{{ route('users.index') }}"><b>{{ __('Create User') }}</b></a>
                       </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }} <x-required></x-required>
                {{ Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 2, 'placeholder' => __('Add Description')]) }}
            </div>
        </div>

        <div class="col-12">
            <hr class="mt-2 mb-2">
            <h4>{{ __('Attendees') }}</h4>
        </div>

        <div class="col-6">
            <div class="form-group">
                {{ Form::label('attendees_user', __('Attendees User'), ['class' => 'form-label']) }} <x-required></x-required>
                {!! Form::select('attendees_user', $user, null, [
                    'class' => 'form-control',
                    'placeholder' => __('Select Attendees User'),
                    'required' => 'required'
                ]) !!}
                <div class=" text-xs">
                            {{ __('Please create User.') }}
                             <a href="{{ route('users.index') }}"><b>{{ __('Create User') }}</b></a>
                       </div>
              

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('attendees_contact', __('Attendees Contact'), ['class' => 'form-label']) }}
                {!! Form::select('attendees_contact', $attendees_contact, null, ['class' => 'form-control']) !!}
                <div class=" text-xs">
                            {{ __('Please create Contact.') }}
                             <a href="{{ route('contact.index') }}"><b>{{ __('Create Contact') }}</b></a>
                       </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('attendees_lead', __('Attendees Lead'), ['class' => 'form-label']) }}
                {!! Form::select('attendees_lead', $attendees_lead, null, ['class' => 'form-control']) !!}
                @if (module_is_active('Lead'))
                    <!--@if (empty($attendees_lead == null))-->
                        <div class=" text-xs">
                            {{ __('Please create first.') }}<a
                                href="{{ route('leads.index') }}"><b>{{ __('Lead') }}</b></a>
                        </div>
                    <!--@endif-->
                @endif
            </div>
        </div>
        @stack('calendar')
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Save'), ['class' => 'btn btn-primary ']) }}
</div>

{{ Form::close() }}
