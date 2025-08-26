{{ Form::open(array('route' => array('dedicated_theme_section_store',$slug), 'method'=>'post', 'enctype' => "multipart/form-data",'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('Heading', __('Heading'), ['class' => 'form-label']) }}
                    {{ Form::text('dedicated_theme_section_heading', null, ['class' => 'custom-form-control', 'placeholder' => __('Enter Heading '), 'required'=>'required']) }}
                    <div class="invalid-feedback">
                        {{ __('Please enter heading') }}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('Description', __('Description'), ['class' => 'form-label']) }}
                    <div class="summernote-container">
                        {{ Form::textarea('dedicated_theme_section_description', '', [
                            'class' => 'summernote form-control', 
                            'placeholder' => __('Enter Description'), 
                            'id' => 'dedicated_theme_section_description',
                            'required' => 'required'
                        ]) }}
                        <div class="invalid-feedback ">
                            Please provide a valid description.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    {{ Form::label('Section Image', __('Section Image'), ['class' => 'form-label']) }}
                    <div class="file-upload">
                        <div class="file-select">
                            <div class="file-select-button" class="fileName">Choose File</div>
                            <div class="file-select-name" id="noFile">No file chosen...</div> 
                            <input type="file" name="dedicated_theme_section_image" class="chooseFile" required>
                            <div class="invalid-feedback" style="position:absolute;top:25px;">
                                {{ __('Please select an image') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border">
                <div class="row pt-3">
                    <div class="col"><h5>{{ __("Section Cards") }}</h5></div>
                    <div class="col-auto text-end">
                        <button id="add-cards-details"
                            class="btn btn-sm btn-primary btn-icon"
                            title="{{ __('Add More Cards') }}" type="button">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
                <div id="add-cards1" class="border-bottom row py-2">
                    <div class="col-md-10">
                        <div class="form-group">
                            {{ Form::label('Title', __('Title'), ['class' => 'form-label']) }}
                            {{ Form::text('dedicated_theme_section_cards[1][title]', null, ['class' => 'form-control', 'placeholder' => __('Enter Title')]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Description', __('Description'), ['class' => 'form-label']) }}
                            {{ Form::text('dedicated_theme_section_cards[1][description]', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
                        </div>
                    </div>
                    <div class="col-md-2 d-flex text-center align-items-center">
                        <a href="#" id="delete-card1" class="card-delete btn btn-danger btn-sm align-items-center bs-pass-para" title="{{__('Delete')}}" data-title="{{__('Delete')}}" data-original-title="{{__('Delete')}}">
                            <i class="ti ti-trash text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
    </div>
{{ Form::close() }}

@push('css')
    <link href="{{  asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')  }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
@endpush


<script>
    $("#add-cards-details").click(function(e){
        e.preventDefault()
    var $div = $('div[id^="add-cards"]:last');
    var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
    var $klon = $div.clone().prop('id', 'add-cards'+num );
    $klon.find('a').each(function() {
        this.id = "delete-card"+num;
    });
    $klon.find('input').each(function() {
    this.value= "";
    let name_number = this.name.match(/\d+/);
    name_number++;
    this.name = this.name.replace(/\[[0-9]\]+/, '['+name_number+']')
    });
    $div.after( $klon );
    });
    $(document).on('click', '.card-delete', function(e) {
        e.preventDefault()

        var id = $(this).attr('id');
        var num = parseInt( id.match(/\d+/g), 10 );
        var card = document.getElementById("add-cards"+num);
        if(num != 1){
            card.remove();
        }
    });
</script>


<script>
$(document).ready(function() {
   
$('.chooseFile, .chooseFile2').bind('change', function () {
  var filename = $(".chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen..."); 
     $("#noFile2").text("No file chosen..."); 
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
    $("#noFile2").text(filename.replace("C:\\fakepath\\", "")); 
  }
});

});
</script>

<style>
.note-editor.is-invalid {
    border-color: #dc3545 !important;
}
.note-editor.is-valid {
    border-color: #28a745 !important;
}
.note-editor.is-invalid::after,
.note-editor.is-valid::after {
    position: absolute;
    top: 50%;
    right: 10px;
    z-index: 5;
    transform: translateY(-50%);
    width: 1rem;
    height: 1rem;
    content: "";
    background-repeat: no-repeat;
    background-position: center center;
    background-size: contain;
}
.note-editor.is-invalid::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ff3a6e' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23ff3a6e' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3e");
}
.note-editor.is-valid::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%236fd943' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
}
.custom-form-control{
    display: block;
    width: 100%;
    padding: 0.575rem 1rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #293240;
    background-color: #ffffff;
    
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 6px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}


.file-upload {
	display: block;
}

.file-upload .file-select {
	display: block;
	border: 1px solid #ced4da;
    border-radius: 6px;
	color: #34495e;
	cursor: pointer;
	height: 40px;
	line-height: 40px;
	text-align: left;
	background: #FFFFFF;
	position: relative;
}

.file-upload .file-select .file-select-button {
	background: #F8F9FD;
	padding: 0 10px;
	display: inline-block;
	height: 38px;
	line-height: 40px;
    border-radius: 6px;
}

.file-upload .file-select .file-select-name {
	line-height: 40px;
	display: inline-block;
	padding: 0 10px;
}


.file-upload .file-select input[type=file] {
	z-index: 100;
	cursor: pointer;
	position: absolute;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	opacity: 0;
	filter: alpha(opacity=0);
}

.file-upload .file-select.file-select-disabled {
	opacity: 0.65;
}




</style>