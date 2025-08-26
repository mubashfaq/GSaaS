@extends('layouts.invoicepayheader')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-5" id="printTable">
                <div class="card-body" id="boxes">
                    <div class="row invoice-title mt-2">
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                            <img src="{{ $img ?? '' }}" style="max-width: 150px;" />
                        </div>
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                            <h3 class="invoice-number">
                                {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->id, $document->created_by, $document->workspace) }}
                            </h3>
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <div class="mb-3">
                                <h6 class="d-inline-block m-0 d-print-none">{{ __('document Type  :') }}</h6>
                                <span class="col-md-8"><span class="text-md">{{ $document_type->name }}</span></span>
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
@push('scripts')
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function closeScript() {
            setTimeout(function() {
                window.open(window.location, '_self').close();
            }, 1000);
        }

        $(window).on('load', function() {
            var element = document.getElementById('boxes');
            var opt = {
                filename: '{{ Workdo\Documents\Entities\Document::documentNumberFormat($document->id, $document->created_by, $document->workspace) }}',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4'
                }
            };

            html2pdf().set(opt).from(element).save().then(closeScript);
        });
    </script>
@endpush
