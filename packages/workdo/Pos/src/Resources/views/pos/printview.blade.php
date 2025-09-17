@php
    $company_settings = getCompanyAllSetting();
@endphp

<div class="pt-0 pb-3 modal-body pos-module px-0" id="printarea">
    <table class="table pos-module-tbl">
        <tbody>
        <div class="text-center ">
            <h3>{{isset($company_settings['company_name']) ? $company_settings['company_name'] : ''}}</h3>
        </div>
        <br>

        <div class="text-left">
            <h3>{{ $details['pos_id'] ?? '' }}</h3>
        </div>

        <div class="text-left" style="font-size: 12px; line-height: 1.3; color:#000;">
            @if(isset($company_settings['company_name']) && !empty($company_settings['company_name']))
                {{ $company_settings['company_name'] }}<br>
            @endif
            
            @if(isset($company_settings['company_email']) && !empty($company_settings['company_email']))
                {{ $company_settings['company_email'] }}<br>
            @endif
            
            @if(isset($company_settings['company_address']) && !empty($company_settings['company_address']))
                {{ $company_settings['company_address'] }}<br>
            @endif
            
            @php
                $location_parts = [];
                if(isset($company_settings['company_city']) && !empty($company_settings['company_city'])) {
                    $location_parts[] = $company_settings['company_city'];
                }
                if(isset($company_settings['company_state']) && !empty($company_settings['company_state'])) {
                    $location_parts[] = $company_settings['company_state'];
                }
                if(isset($company_settings['company_zipcode']) && !empty($company_settings['company_zipcode'])) {
                    $location_parts[] = $company_settings['company_zipcode'];
                }
            @endphp
            
            @if(!empty($location_parts))
                {{ implode(', ', $location_parts) }}<br>
            @endif
            
            @if(isset($company_settings['company_country']) && !empty($company_settings['company_country']))
                {{ $company_settings['company_country'] }}<br>
            @endif
            
            @if(isset($company_settings['company_telephone']) && !empty($company_settings['company_telephone']))
                {{ $company_settings['company_telephone'] }}<br>
            @endif
        </div>

        @if(isset($details['customer']['details']) && !isset($details['customer']['name']))
        <div class="invoice-to mt-2 product-border" style="font-size: 12px; color:#000;">
            {!! $details['customer']['details'] !!}
        </div><br>
        @endif
        
        @if(isset($details['customer']['name']) && !empty($details['customer']['name']))
        <div style="font-size: 14px; margin-bottom: 3px; color:#000;">
            <b>Name:</b> {{ $details['customer']['name'] }}
        </div>
        @endif
        
        @if(isset($details['customer']['address']) && !empty($details['customer']['address']))
        <div style="font-size: 14px; margin-bottom: 3px;color:#000;">
            <b>Address:</b> {{ $details['customer']['address'] }}
        </div>
        @endif
        
        @if(isset($details['customer']['email']) && !empty($details['customer']['email']))
        <div style="font-size: 14px; margin-bottom: 3px; color:#000;">
            <b>Email:</b> {{ $details['customer']['email'] }}
        </div>
        @endif
        
        @if(isset($details['customer']['phone_number']) && !empty($details['customer']['phone_number']))
        <div style="font-size: 16px; margin-bottom: 3px; color:#000;">
            <b>Phone:</b> {{ $details['customer']['phone_number'] }}
        </div>
        @endif
        
        @if(isset($details['date']) && !empty($details['date']))
        <div style="font-size: 16px; margin-bottom: 3px;color:#000;">
            <b>Date:</b> {{ convertToTargetTimezone($details['date']) }}
        </div>
        @endif
        
        @if(isset($details['warehouse']['details']) && !empty($details['warehouse']['details']))
        <div class="product-border" style="font-size: 14px; margin-bottom: 5px;color:#000;">
            <b>Warehouse:</b> {!! strip_tags($details['warehouse']['details']) !!}
        </div>
        @endif
        </tbody>
    </table>

    {{-- FIXED: Added proper null checks and data validation --}}
    @if (isset($sales) && is_array($sales) && array_key_exists('data', $sales) && !empty($sales['data']))
        <table class="table" style="width: 95%; border-collapse: collapse; font-size: 14px;margin:auto;">
            <thead>
                <tr>
                    <th colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <h5 style="margin: 0;color:#000;"><b>{{ __('Product Details') }}</b></h5>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; font-weight: bold; font-size: 18px;color:#000;">{{ __('Product') }}</td>
                        <td style="border: 1px solid #000; padding: 5px; font-weight: bold; text-align: center; font-size: 18px;color:#000;">{{ __('QTY') }}</td>
                        <td style="border: 1px solid #000; padding: 5px; font-weight: bold; text-align: right; font-size: 18px;color:#000;">{{ __('Price') }}</td>
                        <td style="border: 1px solid #000; padding: 5px; font-weight: bold; text-align: right; font-size: 18px;color:#000;">{{ __('Total') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales['data'] as $key => $value)
                        {{-- FIXED: Added null checks for all fields --}}
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px; max-width: 150px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                                <div style="max-width: 100%; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                                    <h6>{{ $value['name'] ?? 'N/A' }}</h6>
                                </div>
                            </td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: center;color:#000;">
                                <h6><b>{{ $value['quantity'] ?? '0' }}</b></h6>
                            </td>
                            {{-- FIXED: Removed extra </h6> tag --}}
                            <td style="border: 1px solid #000; padding: 5px; text-align: right;color:#000;">
                                <h6><b>{{ $value['price'] ?? '0.00' }}</b></h6>
                            </td>
                            <td style="border: 1px solid #000; padding: 5px; text-align: right;color:#000;">
                                <h6><b>{{ $value['subtotal'] ?? '0.00' }}</b></h6>
                            </td>
                        </tr>
                        
                        {{-- Tax Row --}}
                        <tr>
                            <td colspan="2" style="border: 1px solid #000; padding: 5px; font-weight: bold;font-size: 18px;color:#000;">{{ __('Tax') }}</td>
                            <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: right;color:#000;">
                                <h6><b>{{ $value['tax_amount'] ?? '0.00' }}</b></h6>
                            </td>
                        </tr>
                        
                        {{-- Discount Row --}}
                        <tr>
                            <td colspan="2" style="border: 1px solid #000; padding: 5px; font-weight: bold;font-size: 18px;color:#000;">{{ __('Discount') }}</td>
                            <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: right;color:#000;">
                                <h6><b>{{ $value['discount'] ?? '0.00' }}</b></h6>
                            </td>
                        </tr>
                        
                        {{-- Item Separator --}}
                        @if(!$loop->last)
                            <tr><td colspan="4" style="border-bottom: 2px dashed #000;"></td></tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
    @else
        {{-- FIXED: Added fallback when no sales data --}}
        <div class="text-center" style="padding: 20px; color: #666;">
            <p>{{ __('No items found') }}</p>
        </div>
    @endif

    {{-- FIXED: Added null checks for totals section --}}
    <div class="d-flex mt-4">
        <div><h5>{{__('Payment Method:')}}</h5></div>
        <div class="text-end ms-auto"><h5 id="print_payment_type"></h5></div>
    </div>
    
    @if(isset($sales['total_qty']))
    <div class="d-flex">
        <div><h5>{{__('Total QTY:')}}</h5></div>
        <div class="text-end ms-auto"><h5>{{ $sales['total_qty'] }}</h5></div>
    </div>
    @endif
    
    @if(isset($sales['total_tax']))
    <div class="d-flex">
        <div><h5>{{__('Total Tax:')}}</h5></div>
        <div class="text-end ms-auto"><h5>{{ $sales['total_tax'] }}</h5></div>
    </div>
    @endif
    
    @if(isset($sales['discount']))
    <div class="d-flex product-border mb-2">
        <div><h5>{{__('Discount:')}}</h5></div>
        <div class="text-end ms-auto"><h5>{{ $sales['discount'] }}</h5></div>
    </div>
    @endif
    
    @if(isset($sales['total']))
    <div class="d-flex product-border mb-2">
        <div><h4>{{__('Total:')}}</h4></div>
        <div class="text-end ms-auto"><h4>{{ $sales['total'] }}</h4></div>
    </div>
    @endif
</div>

<div class="invoice-footer product-border mb-2">
    @if(!empty($company_settings['pos_footer_title']))
        <h4>{{ $company_settings['pos_footer_title'] }}</h4>
    @endif

    @if(!empty($company_settings['pos_footer_notes']))
        <p style="color:#000; white-space: pre-line;">{!! $company_settings['pos_footer_notes'] !!}</p>
    @endif
</div>

@if(isset($fbrPosId) && !empty(trim($fbrPosId)))
<div class="invoice-footer product-border mb-2" style="text-align: center;">
    <!-- Title centered -->
    <h6 style="color: #000; font-weight: bold; margin-bottom: 10px;">FBR INVOICE #</h6>

    <!-- Invoice ID centered -->
    <p style="color: #000; white-space: pre-line; margin-bottom: 20px;">{!! $fbrPosId !!}</p>

    <!-- QR Code and Image Row -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 15px auto; max-width: 500px;">
        <!-- Left: Logo or other image-->
        <div style="flex: 1; text-align: left;">
            <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRTtI-xKEXiceE-HbvhRoEAqNv9vzTywE5UvAptAIAFZqa_kDXXZTDfM83LpsehGdv5ww&usqp=CAU') }}" alt="Logo" style="max-width: 100px;">
        </div>

        <!-- Right: QR Code  -->
        <div style="flex: 1; text-align: right;">
             <div id="qr-code" style="width: 80px; height: 80px; margin: 0 auto;"></div>
        </div>
    </div>

    <!-- Footer Note -->
    <p style="color: #000; white-space: pre-line; font-size: 14px; margin-top: 10px;">
        Verify this invoice through FBR TaxAsaan MobileApp or SMS at 9966 and win exciting prizes in draw!
    </p>
</div>
@endif

<div class="justify-content-center pt-2 modal-footer">
    <h5 class="text-center font-label" style="width:80%;margin:auto;">
        {{ __('Thank You For Shopping With Us. Please Visit Again.') }}
    </h5>

    <h5 class="text-center font-label" style="font-size:14px;">
        Developed by <strong>GSaaS</strong>
    </h5>
    <br><br>
    
    <button type="button" id="print" class="btn btn-primary btn-sm" onclick="printReceipt(event)">
        {{ __('Print') }}
    </button>
</div>

<style>
    .pos-module .product-border{
        border-bottom: 5px dotted #000000 !important;
    }
    .product-border{
        border-bottom: 5px dotted #000000 !important;
    }

    #print {
        display: inline-block !important;
        position: relative !important;
        z-index: 1000 !important;
        cursor: pointer !important;
    }
    
    @media print {
        #print, .modal-header, .modal-footer {
            display: none !important;
        }
        .modal-body {
            padding: 0 !important;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
        #printarea {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
    
    .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
        padding: 8px 16px !important;
        border-radius: 4px !important;
        border: none !important;
    }
    
    .btn-primary:hover {
        background-color: #0056b3 !important;
        border-color: #0056b3 !important;
    }

    /* QR Code container styling */
    #qr-code {
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
    }
</style>

<script>
    // Prevent multiple script executions
    if (window.qrCodeScriptExecuted) {
        console.log('QR code script already executed, skipping...');
    } else {
        window.qrCodeScriptExecuted = true;
        
        // QR Code Library Loading with Fallback
        // Use window object to prevent redeclaration errors
        if (typeof window.qrCodeLoaded === 'undefined') {
            window.qrCodeLoaded = false;
        }
        if (typeof window.qrCodeRetries === 'undefined') {
            window.qrCodeRetries = 0;
        }
        if (typeof window.qrCodeInitialized === 'undefined') {
            window.qrCodeInitialized = false;
        }
        if (typeof window.maxRetries === 'undefined') {
            window.maxRetries = 3;
        }

    // Function to load QR code library
    function loadQRCodeLibrary() {
        return new Promise((resolve, reject) => {
            // Check if already loaded
            if (typeof QRCode !== 'undefined') {
                window.qrCodeLoaded = true;
                resolve();
                return;
            }
            
            // Check if script is already being loaded
            if (document.querySelector('script[src*="qrcode"]')) {
                console.log('QR code script already loading, waiting...');
                // Wait for existing script to load
                const checkInterval = setInterval(() => {
                    if (typeof QRCode !== 'undefined') {
                        window.qrCodeLoaded = true;
                        clearInterval(checkInterval);
                        resolve();
                    }
                }, 100);
                return;
            }

            // Try CDN first
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js';
            script.onload = function() {
                window.qrCodeLoaded = true;
                console.log('QR Code library loaded from CDN');
                resolve();
            };
            script.onerror = function() {
                console.warn('CDN QR library failed, trying alternative CDN');
                // Try alternative CDN
                const altScript = document.createElement('script');
                altScript.src = 'https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js';
                altScript.onload = function() {
                    window.qrCodeLoaded = true;
                    console.log('QR Code library loaded from alternative CDN');
                    resolve();
                };
                altScript.onerror = function() {
                    console.error('All CDN sources failed');
                    reject(new Error('QR Code library could not be loaded'));
                };
                document.head.appendChild(altScript);
            };
            document.head.appendChild(script);
        });
    }

    $(document).ready(function() {
        $('#print_payment_type').html(localStorage.getItem("payment_type"));
        
        // Prevent multiple initializations
        if (window.qrCodeInitialized) {
            console.log('QR code already initialized, skipping...');
            return;
        }
        
        window.qrCodeInitialized = true;
        
        // Load QR library and initialize
        loadQRCodeLibrary()
            .then(() => {
                initializeQRCode();
            })
            .catch(() => {
                // If library fails to load, use fallback
                console.log('Using fallback QR code generation');
                initializeQRCodeWithFallback();
            });
            
        // Ensure print button is properly initialized
        setTimeout(function() {
            var printBtn = document.getElementById('print');
            if (printBtn) {
                console.log('Print button found and initialized');
                // Ensure the onclick handler is set
                if (!printBtn.onclick) {
                    printBtn.onclick = function(e) {
                        e.preventDefault();
                        printReceipt(e);
                    };
                }
            } else {
                console.error('Print button not found');
            }
        }, 1000);
    });

    $("#print").click(function () {
        console.log('Print button clicked');
        var print_div = document.getElementById("printarea");
        if (!print_div) {
            console.error('Print area not found');
            return;
        }
        
        // Hide elements before printing
        $('.row').addClass('d-none');
        $('.toast').addClass('d-none');
        $('#print').addClass('d-none');
        
        // Add a small delay to ensure elements are hidden
        setTimeout(function() {
            try {
                window.print();
                console.log('Print dialog opened');
            } catch (error) {
                console.error('Error opening print dialog:', error);
            }
            
            // Restore elements after printing
            setTimeout(function() {
                $('.row').removeClass('d-none');
                $('#print').removeClass('d-none');
                $('.toast').removeClass('d-none');
            }, 1000);
        }, 100);
    });

    // Alternative event binding using document delegation
    $(document).on('click', '#print', function(e) {
        e.preventDefault();
        console.log('Print button clicked (delegated)');
        var print_div = document.getElementById("printarea");
        if (!print_div) {
            console.error('Print area not found');
            return;
        }
        
        // Hide elements before printing
        $('.row').addClass('d-none');
        $('.toast').addClass('d-none');
        $('#print').addClass('d-none');
        
        // Add a small delay to ensure elements are hidden
        setTimeout(function() {
            try {
                window.print();
                console.log('Print dialog opened');
            } catch (error) {
                console.error('Error opening print dialog:', error);
            }
            
            // Restore elements after printing
            setTimeout(function() {
                $('.row').removeClass('d-none');
                $('#print').removeClass('d-none');
                $('.toast').removeClass('d-none');
            }, 1000);
        }, 100);
    });

    // Vanilla JavaScript fallback
    document.addEventListener('DOMContentLoaded', function() {
        var printButton = document.getElementById('print');
        if (printButton) {
            printButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Print button clicked (vanilla JS)');
                
                var print_div = document.getElementById("printarea");
                if (!print_div) {
                    console.error('Print area not found');
                    return;
                }
                
                // Hide elements before printing
                var rows = document.querySelectorAll('.row');
                var toasts = document.querySelectorAll('.toast');
                var printBtn = document.getElementById('print');
                
                rows.forEach(function(row) {
                    row.classList.add('d-none');
                });
                toasts.forEach(function(toast) {
                    toast.classList.add('d-none');
                });
                if (printBtn) {
                    printBtn.classList.add('d-none');
                }
                
                // Add a small delay to ensure elements are hidden
                setTimeout(function() {
                    try {
                        window.print();
                        console.log('Print dialog opened');
                    } catch (error) {
                        console.error('Error opening print dialog:', error);
                    }
                    
                    // Restore elements after printing
                    setTimeout(function() {
                        rows.forEach(function(row) {
                            row.classList.remove('d-none');
                        });
                        toasts.forEach(function(toast) {
                            toast.classList.remove('d-none');
                        });
                        if (printBtn) {
                            printBtn.classList.remove('d-none');
                        }
                    }, 1000);
                }, 100);
            });
        }
    });

    // Inline onclick handler function
    function printReceipt(event) {
        event.preventDefault();
        console.log('Print button clicked (inline handler)');
        
        var print_div = document.getElementById("printarea");
        if (!print_div) {
            console.error('Print area not found');
            return;
        }
        
        // Hide elements before printing
        var rows = document.querySelectorAll('.row');
        var toasts = document.querySelectorAll('.toast');
        var printBtn = document.getElementById('print');
        
        rows.forEach(function(row) {
            row.classList.add('d-none');
        });
        toasts.forEach(function(toast) {
            toast.classList.add('d-none');
        });
        if (printBtn) {
            printBtn.classList.add('d-none');
        }
        
        // Add a small delay to ensure elements are hidden
        setTimeout(function() {
            try {
                window.print();
                console.log('Print dialog opened');
            } catch (error) {
                console.error('Error opening print dialog:', error);
            }
            
            // Restore elements after printing
            setTimeout(function() {
                rows.forEach(function(row) {
                    row.classList.remove('d-none');
                });
                toasts.forEach(function(toast) {
                    toast.classList.remove('d-none');
                });
                if (printBtn) {
                    printBtn.classList.remove('d-none');
                }
            }, 1000);
        }, 100);
    }

    // Make printReceipt function globally available
    window.printReceipt = printReceipt;

    function initializeQRCode() {
        // Get the FBR POS ID from PHP
        let fbrPosId = {!! json_encode($fbrPosId ?? '') !!};
        
        console.log('FBR POS ID:', fbrPosId);
        
        if (fbrPosId && fbrPosId.trim() !== "") {
            generateQrCode(fbrPosId);
        } else {
            console.log('No FBR POS ID found or empty');
            document.getElementById("qr-code").innerHTML = '<p style="font-size: 10px; color: #666;">No QR Data</p>';
        }
    }

    function initializeQRCodeWithFallback() {
        // Get the FBR POS ID from PHP
        let fbrPosId = {!! json_encode($fbrPosId ?? '') !!};
        
        console.log('Using fallback QR generation for FBR POS ID:', fbrPosId);
        
        if (fbrPosId && fbrPosId.trim() !== "") {
            generateFallbackQR(fbrPosId);
        } else {
            console.log('No FBR POS ID found or empty');
            document.getElementById("qr-code").innerHTML = '<p style="font-size: 10px; color: #666;">No QR Data</p>';
        }
    }

    function generateQrCode(qrContent) {
        const qrContainer = document.getElementById("qr-code");
        if (!qrContainer) {
            console.error('QR container not found');
            return;
        }

        // Clear any existing content
        qrContainer.innerHTML = "";

        // Retry mechanism
        if (!window.qrCodeLoaded && window.qrCodeRetries < window.maxRetries) {
            window.qrCodeRetries++;
            console.log(`QR library not ready, retrying... (${window.qrCodeRetries}/${window.maxRetries})`);
            setTimeout(() => generateQrCode(qrContent), 500);
            return;
        }

        try {
            // Check if QRCode library is loaded
            if (typeof QRCode === 'undefined') {
                console.error('QRCode library not loaded after retries, using fallback');
                generateFallbackQR(qrContent);
                return;
            }

            // Generate QR code
            new QRCode(qrContainer, {
                text: qrContent,
                width: 100,
                height: 100,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H,
            });
            
            console.log('QR code generated successfully');
            
        } catch (error) {
            console.error('Error generating QR code:', error);
            generateFallbackQR(qrContent);
        }
    }

    function generateFallbackQR(text) {
        const qrContainer = document.getElementById("qr-code");
        if (!qrContainer) return;
        
        // Clear any existing content
        qrContainer.innerHTML = "";
        
        // Create a styled text-based QR placeholder
        qrContainer.innerHTML = `
            <div style="
                border: 2px solid #000; 
                padding: 8px; 
                font-size: 6px; 
                word-break: break-all; 
                width: 100px; 
                height: 100px; 
                overflow: hidden;
                background: #fff;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: monospace;
                line-height: 1.2;
            ">
                <div>
                    <div style="font-weight: bold; margin-bottom: 2px;">FBR Invoice</div>
                    <div style="font-size: 5px;">${text}</div>
                </div>
            </div>
        `;
        
        console.log('Fallback QR code generated');
    }

    // Final fallback: Try to initialize QR code after a delay if not done yet
    setTimeout(function() {
        const qrContainer = document.getElementById("qr-code");
        if (qrContainer && qrContainer.innerHTML === "") {
            console.log('Final fallback: Initializing QR code');
            if (window.qrCodeLoaded) {
                initializeQRCode();
            } else {
                initializeQRCodeWithFallback();
            }
        }
    }, 2000);
    } // End of else block for script execution prevention
</script>