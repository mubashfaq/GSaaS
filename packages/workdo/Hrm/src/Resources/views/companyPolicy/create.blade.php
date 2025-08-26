@php
    $company_settings = getCompanyAllSetting();
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{ Form::open(['url' => 'company-policy', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @include('aiassistant::ai.generate_ai_btn', [
                'template_module' => 'company policy',
                'module' => 'Hrm',
            ])
        @endif
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('branch', !empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('branch', $branches, null, ['class' => 'form-control    ', 'placeholder' => __('Select ' . (!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __(' Branch'))), 'required' => 'required']) }}
            <div class="text-xs">
                   {{ __('Please add Branch. ') }}
                   <a href="{{ route('branch.index') }}"><b>{{ __('Add Branch') }}</b></a>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Company Policy Title')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => __('Enter Description')]) }}
            </div>
        </div>
        <!--<div class="col-md-12">-->
        <!--    <div class="form-group">-->
        <!--        {{ Form::label('document', __('Attachment'), ['class' => 'form-label']) }}-->
        <!--        <div class="choose-file form-group">-->
        <!--            <label for="attachment">-->
        <!--                <input type="file" class="form-control file" name="attachment" id="attachment"-->
        <!--                    onchange="previewImage(this)" data-filename="attachment">-->
        <!--            </label>-->
        <!--            <hr>-->
        <!--            <img id="blah" width="100" src="" style="display: none;" />-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="col-md-12">
    <div class="form-group">
        {{ Form::label('document', __('Attachment'), ['class' => 'form-label']) }}
        <div class="choose-file form-group">
            <label for="attachment">
                <input type="file" class="form-control file" name="attachment" id="attachment"
                    onchange="previewAttachment(this)" data-filename="attachment">
            </label>
            <hr>
            <img id="blah" width="100" src="" style="display: none;" />
            <i id="pdf-icon" class="fa fa-file-pdf-o" style="font-size: 100px; color: #dc3545; display: none;"></i>
        </div>
    </div>
</div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}

<script>
    function previewAttachment(input) {
        const imgPreview = document.getElementById('blah');
        const pdfIcon = document.getElementById('pdf-icon');
        
        // Reset displays
        imgPreview.style.display = 'none';
        pdfIcon.style.display = 'none';
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            if (file.type.startsWith('image/')) {
                // For image files
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = 'block';
            } else if (file.type === 'application/pdf') {
                // For PDF files
                pdfIcon.style.display = 'block';
            }
        }
    }
</script>
