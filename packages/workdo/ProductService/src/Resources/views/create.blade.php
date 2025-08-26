@extends('layouts.main')
@section('page-title')
    {{ __('Create Items') }}
@endsection
@section('page-breadcrumb')
    {{ __('Item') }}
@endsection
@section('page-action')
<div class="d-flex">
    <x-back-button  route="{{ url('/product-service') }}" />
    <div class="col-auto" style="width: 143px;">
        {{ Form::select('item_type', $product_type, isset($_GET['item_type']) ? $_GET['item_type'] : null, ['id' => 'item_type', 'class' => 'form-control select ', 'required' => 'required']) }}
    </div>
</div>    
@endsection

@section('content')
    <div class="row">
        <div id="loader" class="card card-flush">
            <div class="card-body">
                <div class="row">
                    <img class="loader" src="{{ asset('public/images/loader.gif') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    {{ Form::open(['route' => 'product-service.store', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate']) }}
        {{ Form::hidden('type', null, ['id' => 'type']) }}
        <div class="section_div">
        </div>
    {{ Form::close() }}
@endsection
@push('scripts')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var selectedType = $('#item_type').val();
                $('#type').val(selectedType);
        });
        $('#item_type').change(function() {
            var selectedType = $(this).val();
            $('#type').val(selectedType);
        });

        $(document).ready(function() {
            ItemSectionGet();
        });

        $('#item_type').on('change', function()
        {
            ItemSectionGet();
            $.ajax({
                beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
            });
        });

        function ItemSectionGet() {
            var item_type = $('#item_type').val();
            $.ajax({
                url: "{{ route('product.section.type') }}",
                type: 'POST',
                data: {
                    "item_type": item_type,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                        if (response != false) {
                        $('.section_div').html(response.html);
                        $("#loader").addClass('d-none');
                        $(".loader-wrapper").addClass('d-none');
                        JsSearchBox();
                        choices();

                    } else {
                        $('.section_div').html('');
                        toastrs('Error', 'Something went wrong please try again !', 'error');
                    }
                }
            });
        }
    </script>
    <script>
       
        
      function changetab(tabname) {
    console.log("Changing to tab:", tabname);
    
    // Define tab order for validation
    const tabOrder = [
        '#personal-details-tab',
        '#company-tab',
        '#pricing-tab',
        '#media-tab',
        '#warehouse-tab'
    ];
    
    // Find index of current active tab
    const activeTabId = $('.tab-pane.active').attr('id');
    const currentTabIndex = tabOrder.findIndex(tab => tab === '#' + activeTabId);
    
    // Find index of destination tab
    const targetTabIndex = tabOrder.findIndex(tab => tab === tabname);
    
    console.log("Current tab:", activeTabId, "index:", currentTabIndex);
    console.log("Target tab:", tabname, "index:", targetTabIndex);
    
    // Only validate when moving forward in the tab sequence
    if (targetTabIndex > currentTabIndex) {
        // Validate the current tab
        const currentTabSelector = '#' + activeTabId;
        const isValid = validateTab(currentTabSelector);
        
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill all required fields in the current tab before proceeding.',
                confirmButtonText: 'OK'
            });
            return false;
        }
    }
    
    // If validation passed or going backwards, proceed with tab change
    var someTabTriggerEl = document.querySelector('button[data-bs-target="' + tabname + '"]');
    var actTab = new bootstrap.Tab(someTabTriggerEl);
    actTab.show();
}

function validateTab(tabSelector) {
    console.log("Validating tab:", tabSelector);
    
    // Select the tab content
    const tabContent = document.querySelector(tabSelector);
    if (!tabContent) {
        console.error("Tab content not found:", tabSelector);
        return true; // If we can't find the tab, don't block navigation
    }
    
    // Find all required fields in this tab
    const requiredFields = tabContent.querySelectorAll('[required]');
    console.log("Found", requiredFields.length, "required fields");
    
    let isValid = true;
    
    // Reset previous validation errors
    const invalidFields = tabContent.querySelectorAll('.is-invalid');
    invalidFields.forEach(field => {
        field.classList.remove('is-invalid');
    });
    
    // Validate each required field
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            console.log("Empty field found:", field);
            isValid = false;
            field.classList.add('is-invalid');
        }
    });
    
    return isValid;
}

        function generateSKU(){
            var sku = 'SKU-' + Math.random().toString(24).substr(2, 7);
            $('input[name=sku]').val(sku.toUpperCase());
        }
    </script>
@endpush
