@extends('layouts.main')
@section('page-title')
    {{__('Call Edit')}}
@endsection
@section('title')
        {{__('Edit Call')}}
@endsection
@section('page-action')
    <div class="d-flex">
        
          <x-back-button  route="{{ url('/call') }}" />
        @if(!empty($previous))
            <a href="{{ route('call.edit',$previous) }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="{{__('Previous')}}">
                <i class="ti ti-chevron-left"></i>
            </a>
        @else
            <a href="#" class="btn btn-sm btn-primary btn-icon me-2 disabled" data-bs-toggle="tooltip" title="{{__('Previous')}}">
                <i class="ti ti-chevron-left"></i>
            </a>
        @endif
        @if(!empty($next))
            <a href="{{ route('call.edit',$next) }}" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" title="{{__('Next')}}">
                <i class="ti ti-chevron-right"></i>
            </a>
        @else
            <a href="#" class="btn btn-sm btn-primary btn-icon disabled" data-bs-toggle="tooltip" title="{{__('Next')}}">
                <i class="ti ti-chevron-right"></i>
            </a>
        @endif
    </div>
@endsection
@section('page-breadcrumb')
  {{__('Call')}},
  {{__('Edit')}}
@endsection
@section('content')
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-3">
                <div class="card sticky-top" style="top:30px">
                    <div class="list-group list-group-flush" id="useradd-sidenav">
                        <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('Overview') }} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div id="useradd-1" class="card">
                    {{Form::model($call,array('route' => array('call.update', $call->id),'class'=>'needs-validation','novalidate', 'method' => 'PUT')) }}
                    <div class="card-header">
                        <div class="float-end">
                            @if (module_is_active('AIAssistant'))
                                @include('aiassistant::ai.generate_ai_btn',['template_module' => 'call','module'=>'Sales'])
                            @endif
                        </div>
                        <h5>{{ __('Overview') }}</h5>
                        <small class="text-muted">{{__('Edit about your call information')}}</small>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('name',__('Name'),['class'=>'form-label']) }} <x-required></x-required>
                                        {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                                        @error('name')
                                        <span class="invalid-name" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                    {{Form::label('status',__('Status'),['class'=>'form-label']) }} <x-required></x-required>
                                    {!!Form::select('status', $status, null,array('class' => 'form-control','required'=>'required')) !!}
                                    @error('status')
                                    <span class="invalid-status" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                    {{Form::label('start_date',__('Start Date'),['class'=>'form-label']) }}
                                    {!!Form::date('start_date', null,array('class' => 'form-control','required'=>'required')) !!}
                                    @error('start_date')
                                    <span class="invalid-start_date" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('end_date',__('End Date'),['class'=>'form-label']) }}
                                        {!!Form::date('end_date', null,array('class' => 'form-control','required'=>'required')) !!}
                                        @error('end_date')
                                        <span class="invalid-end_date" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                    {{Form::label('direction',__('Direction'),['class'=>'form-label']) }}
                                    {!!Form::select('direction', $direction, null,array('class' => 'form-control','required'=>'required')) !!}
                                    @error('direction')
                                    <span class="invalid-direction" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('description',__('Description'),['class'=>'form-label']) }} <x-required></x-required>
                                        {{Form::textarea('description',null,array('class'=>'form-control','rows'=>2,'placeholder'=>__('Add Description'),'required'=>'required'))}}
                                        @error('description')
                                        <span class="invalid-description" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                    {{Form::label('account',__('Account'),['class'=>'form-label']) }} <x-required></x-required>
                                    {!! Form::select('account', $account_name, null,array('class' => 'form-control')) !!}
                                    <div class=" text-xs">
                                            {{ __('Please create Account.') }}
                                             <a href="{{ route('salesaccount.index') }}"><b>{{ __('Create Account') }}</b></a>
                                       </div>
                                    </div>
                                    @error('account')
                                    <span class="invalid-account" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('user_id',__('Assigned User'),['class'=>'form-label']) }} <x-required></x-required>
                                        {!! Form::select('user_id', $user, null,array('class' => 'form-control','required'=>'required')) !!}
                                        <div class=" text-xs">
                                            {{ __('Please create User.') }}
                                             <a href="{{ route('users.index') }}"><b>{{ __('Create User') }}</b></a>
                                       </div>
                                        @error('user')
                                        <span class="invalid-user" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <h4 class="mt-2">{{__('Attendees')}}</h4>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('attendees_user',__('User'),['class'=>'form-label']) }} <x-required></x-required>
                                        {!! Form::select('attendees_user', $user, null,array('class' => 'form-control','placeholder'=>__('Select Attendees User'))) !!}
                                        <div class=" text-xs">
                                            {{ __('Please create User.') }}
                                             <a href="{{ route('users.index') }}"><b>{{ __('Create User') }}</b></a>
                                       </div>
                                        @error('attendees_user')
                                        <span class="invalid-attendees_user" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('attendees_contact',__('Contact'),['class'=>'form-label']) }}
                                        {!! Form::select('attendees_contact', $attendees_contact, null,array('class' => 'form-control')) !!}
                                        <div class=" text-xs">
                                            {{ __('Please create Contact.') }}
                                             <a href="{{ route('contact.index') }}"><b>{{ __('Create Contact') }}</b></a>
                                       </div>
                                        @error('attendees_contact')
                                        <span class="invalid-attendees_contact" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {{Form::label('attendees_lead',__('Lead'),['class'=>'form-label']) }}
                                        {!! Form::select('attendees_lead', $attendees_lead, null,array('class' => 'form-control')) !!}
                                            <div class=" text-xs">
                                                {{ __('Please create first.') }}<a
                                                    href="{{ route('leads.index') }}"><b>{{ __('Lead') }}</b></a>
                                            </div>
                                        @error('attendees_lead')
                                        <span class="invalid-attendees_lead" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-end">
                                    {{Form::submit(__('Update'),array('class'=>'btn-submit btn btn-primary'))}}
                                </div>


                            </div>
                        </form>
                    </div>
                    {{Form::close()}}
                </div>

            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>




@endsection
@push('scripts')
<script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#useradd-sidenav',
        offset: 300
    })
</script>
@endpush
