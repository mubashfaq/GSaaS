<div class="menu-qr-card mx-sm-5 my-4 m-4" >
    <div class="card qr-card-wrp overflow-hidden mb-4 p-0 border" id="printableArea">
        <div class="card-body pt-0"> 
            <div class="qr-card-bg">
                <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/qr_code_bg.png')}}" alt="layer">
            </div>
            <div class="card-body-top text-center mb-sm-5 mb-4">
                <h2 class="mb-0 fs-1 f-w-700">{{ $diningTable->name }}</h2>
            </div>
            <div class="card-body-bottom">
                <div class="menu-image border">
                <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/menu.png')}}" alt="layer">
                </div>
                <div class="qr-image mb-4">
                    {!! DNS2D::getBarcodeHTML(route('restaurant-qr-reader', ['workspace' => $workspaceSlug->slug, 'table_id' => $diningTable->id]), 'QRCODE', 4, 4) !!}
                </div>
                <div class="qr-content text-center">
                    <h3 class="mb-0 fs-2 text-white">Scan Me</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="qr-btn-wrp text-center">    
        <a id="downloadBtn" class="btn btn-sm btn-primary text-white" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="{{ __('Download') }}" onclick="saveAsPDF()">
            <span class="ti ti-download"></span>
        </a>

        <a href="#"
            class="bg-primary btn btn-sm align-items-center cp_link"
            data-link="{{route('restaurant-qr-reader', ['workspace' => $workspaceSlug->slug, 'table_id' => $diningTable->id])}}"
            data-bs-whatever="{{ __('Copy Link') }}"
            data-bs-toggle="tooltip"
            data-bs-original-title="{{ __('Copy Link') }}"> <span
                class="text-white">{{ __('Click to Link Copy') }}</span></a>
    </div>
</div>

<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>

<script>
    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var downloadBtn = document.getElementById('downloadBtn');


        var opt = {
            margin: 0.3,          
            image: { type: 'jpeg', quality: 1 },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: { unit: 'in', format: 'A4' }
        };

        html2pdf().set(opt).from(element).save().then(function () {
            downloadBtn.style.display = 'inline-block';
        });
        
    }
</script>
<script type="text/javascript">
    $(document).on('click', '.cp_link', async function(event) {
        var value = $(this).attr('data-link');
        try {
            await navigator.clipboard.writeText(value);
            toastrs('Success', '{{ __("Link Copied to Clipboard") }}', 'success');
        } catch (err) {
            toastrs('Error', '{{ __("Failed to Copy Link") }}', 'error');
        }
    });
</script>