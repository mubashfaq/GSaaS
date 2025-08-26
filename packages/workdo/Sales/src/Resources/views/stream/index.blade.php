@extends('layouts.main')
@section('page-title')
    {{ __('Manage Stream') }}
@endsection
@section('title')
    {{ __('Stream') }}
@endsection
@section('page-breadcrumb')
    {{ __('Stream') }}
@endsection
@section('page-action')
@endsection
@section('filter')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Latest comments') }}</h5>
                </div>
                <div class="card-body">
                    @foreach ($streams as $stream)
                        @php
                            $remark = json_decode($stream->remark);
                        @endphp
                        <div class="row">

                            <div class="col-xl-12">
                                <ul class="list-group">
                                    <li class=" list-group-item border-0 d-flex align-items-start">
                                        <div class="avatar col-1">
                                            <a href="{{ (!empty($stream->file_upload) && check_file($stream->file_upload)) ? get_file($stream->file_upload) : get_file('uploads/users-avatar/avatar.png') }}" target="_blank" class="users-image">

                                                <img src="{{ (!empty($stream->file_upload) && check_file($stream->file_upload)) ? get_file($stream->file_upload) : get_file('uploads/users-avatar/avatar.png') }}"
                                                    class="rounded border-2 border border-primary">
                                            </a>
                                        </div>
                                        <div class="col-11 d-block d-sm-flex align-items-center right-side">
                                            <div class="col-10 d-flex align-items-start flex-column justify-content-center">
                                                <div class="h6">{{ ucfirst($remark->user_name) }}
                                                </div>
                                                <span class="text-sm lh-140 mb-0">
                                                    {{ __('posted to ') }}<a href="#">{{ $remark->title }}</a> {{ __(',') }} 
                                                    {{ $stream->log_type }} <a href="#">{{ $remark->stream_comment }}</a>
                                                </span>
                                            </div>
                                            <div class="col-2 d-flex align-items-center ">
                                                <small class="text-end">{{ $stream->created_at }}</small>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['stream.destroy', $stream->id]]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm align-items-center text-white show_confirm bg-danger" data-bs-toggle="tooltip"
                                                    title="{{__('Delete')}}" data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
