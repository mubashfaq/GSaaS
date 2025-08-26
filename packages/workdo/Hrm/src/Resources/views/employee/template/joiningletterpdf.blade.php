@extends('hrm::layouts.contractheader')
@section('page-title')
    {{ __('Joining Letter') }}
@endsection
@push('css')
    <style>
        html[dir="rtl"] {
            letter-spacing: 0.1px;
        }
        
        /* Maintain padding and fix page breaks */
        @media print {
            .page-content {
                page-break-inside: avoid;
                break-inside: avoid;
                padding-left: 15px !important; /* Force left padding */
                padding-right: 15px !important;
            }
            
            #boxes {
                margin-bottom: 30mm;
                padding-left: 15px !important; /* Force left padding */
            }
            
            p {
                orphans: 4;
                widows: 4;
                margin-bottom: 10px;
                padding-left: inherit !important; /* Preserve inherited padding */
            }
            
            /* Additional rule to preserve padding */
            .card-body {
                padding-left: 15px !important;
            }
            
            /* Preserve any existing container padding */
            .container, .col-lg-10, .row {
                padding-left: inherit !important;
            }
        }
        
        /* Non-print styles to ensure padding in preview */
        .page-content {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        #boxes {
            padding-left: 15px;
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="container">
                <div>
                    <div class="card mt-5" id="printTable">
                        <div class="card-body" id="boxes">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 text-end">
                                    <img src="{{ !empty(get_file(sidebar_logo())) ? get_file(sidebar_logo()) : 'WorkDo' }}"
                                        style="max-width: 150px;" />
                                </div>
                                <div class="page-content">
                                    {!! $joiningletter->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
        <script>
            function closeScript() {
                setTimeout(function() {
                    window.open(window.location, '_self').close();
                }, 1000);
            }
            
            $(window).on('load', function() {
                // This function will preserve padding
                function preservePadding() {
                    // Store original padding values
                    var boxes = document.getElementById('boxes');
                    var originalPadding = window.getComputedStyle(boxes).paddingLeft;
                    
                    // Apply to all elements that might need it
                    var contentElements = document.querySelectorAll('.page-content, .card-body, #boxes, p');
                    contentElements.forEach(function(element) {
                        if (window.getComputedStyle(element).paddingLeft) {
                            element.setAttribute('data-original-padding', window.getComputedStyle(element).paddingLeft);
                            element.style.paddingLeft = window.getComputedStyle(element).paddingLeft;
                        }
                    });
                }
                
                // Run the padding preservation function
                preservePadding();
                
                var element = document.getElementById('boxes');
                var opt = {
                    filename: '{{ $employees->name }}',
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 4,
                        dpi: 72,
                        letterRendering: true,
                        useCORS: true,
                        logging: true,
                        windowHeight: 1500,
                        onclone: function(clonedDoc) {
                            // Ensure padding is preserved in the cloned document
                            var clonedElements = clonedDoc.querySelectorAll('.page-content, .card-body, #boxes, p');
                            clonedElements.forEach(function(element) {
                                if (element.getAttribute('data-original-padding')) {
                                    element.style.paddingLeft = element.getAttribute('data-original-padding');
                                } else {
                                    element.style.paddingLeft = '15px';
                                }
                            });
                        }
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait',
                        margin: [15, 15, 25, 15], // [top, right, bottom, left]
                        compress: false
                    },
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'legacy'],
                        before: '.page-break-before',
                        after: '.page-break-after',
                        avoid: '.keep-together'
                    }
                };
                
                html2pdf()
                    .set(opt)
                    .from(element)
                    .toPdf()
                    .get('pdf')
                    .then(function(pdf) {
                        // Add more space to the bottom of the page
                        var totalPages = pdf.internal.getNumberOfPages();
                        for (var i = 1; i <= totalPages; i++) {
                            pdf.setPage(i);
                            pdf.setFontSize(10);
                            pdf.setTextColor(150);
                            // Add some extra space at the bottom
                            pdf.text(' ', pdf.internal.pageSize.getWidth() / 2, pdf.internal.pageSize.getHeight() - 10);
                        }
                    })
                    .save()
                    .then(closeScript)
                    .catch(function(error) {
                        console.error('Error generating PDF:', error);
                        alert('There was an error generating the PDF. Please try again.');
                    });
            });
        </script>
    @endpush