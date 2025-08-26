{{ Form::open(['url' => 'document', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @include('aiassistant::ai.generate_ai_btn', [
                'template_module' => 'document',
                'module' => 'Hrm',
            ])
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', __('Names'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Document Name')]) }}
            </div>
        </div>
        <div class="form-group col-md-12">
    {{ Form::label('document', __('Document'), ['class' => 'form-label']) }}<x-required></x-required>
    <div class="choose-file">
        <input type="file" class="form-control file doc_data" name="documents" id="documents"
            data-filename="documents" required="required"
            onchange="previewFile(this);" style="width:456px;">
        <div id="preview-container" class="mt-3">
            <img id="blah" width="25%" style="display: none;">
            <i id="pdf-icon" class="fas fa-file-pdf fa-3x" style="color: #dc3545; display: none;"></i>
        </div>
    </div>
</div>
        <!--<div class="form-group col-md-12">-->
        <!--    {{ Form::label('document', __('Document'), ['class' => 'form-label']) }}<x-required></x-required>-->
        <!--    <div class="choose-file">-->
        <!--            <input type="file" class="form-control file doc_data" name="documents" id="documents"-->
        <!--                data-filename="documents" required="required"-->
        <!--                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" style="width:456px;">-->
        <!--            <img id="blah" width="25%" class="mt-3">-->
        <!--        </label>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="col-12">
            <div class="form-group">
                {{ Form::label('role', __('Role'), ['class' => 'form-label']) }}
                {{ Form::select('role', $roles, null, ['class' => 'form-control ', 'required' => 'required']) }}
            <div class="text-xs">
                   {{ __('Please add Role. ') }}
                   <a href="{{ route('roles.index') }}"><b>{{ __('Add Role') }}</b></a>
            </div>
            </div>
           
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => __('Enter Description')]) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary submit']) }}
</div>
{{ Form::close() }}
{{-- <script>
     $(".submit").click(function() {
            var documents = $('.doc_data').val();
            if(!isNaN(documents)) {
                    $('#doc_validation').removeClass('d-none')
                    return false;
            }else{
                $('#doc_validation').addClass('d-none')
            }
        });
</script> --}}

<script>
function previewFile(input) {
    var file = input.files[0];
    var previewImg = document.getElementById('blah');
    var pdfIcon = document.getElementById('pdf-icon');
    
    // Reset displays
    previewImg.style.display = 'none';
    pdfIcon.style.display = 'none';
    
    if (file) {
        // Check file type
        if (file.type.startsWith('image/')) {
            // It's an image
            previewImg.src = window.URL.createObjectURL(file);
            previewImg.style.display = 'block';
        } else if (file.type === 'application/pdf') {
            // It's a PDF
            pdfIcon.style.display = 'block';
        }
    }
}
</script>
