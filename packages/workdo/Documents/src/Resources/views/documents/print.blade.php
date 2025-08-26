@extends('layouts.invoicepayheader')
@section('page-title')
    {{ __('Document  Detail') }}
@endsection
@section('action-btn')
    <div>
        <a href="{{ route('document.download.pdf', \Crypt::encrypt($document->id)) }}" target="_blanks"
            class="btn btn-sm btn-primary py-2" title="{{ __('Download') }}" data-bs-toggle="tooltip" data-bs-placement="top"><i
                class="ti ti-download"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" id="printTable">
                <div class="card-body">
                    <div class="row invoice-title mt-2">
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                            <img src="{{ $img ?? '' }}" style="max-width: 150px;" />
                        </div>
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                            <h3 class="invoice-number">
                                {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->document_id, $document->created_by, $document->workspace) }}
                            </h3>
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <div class="mb-3">
                                <h6 class="d-inline-block m-0 d-print-none">{{ __('Document  Type  :') }}</h6>
                                <span class="col-md-8">
                                    <span class="text-md">
                                        {{ isset($document->Type->name) ? $document->Type->name : '' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <p data-v-f2a183a6="">

                    <div>{!! $document->notes ?? '' !!}</div>
                    <br>
                    <div>{!! $document->description ?? '' !!}</div>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
