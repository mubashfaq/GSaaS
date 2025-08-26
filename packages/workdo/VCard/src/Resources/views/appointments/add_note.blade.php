<link href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet">
{{ Form::open(['route' => ['appointment.note.store', $appointment->id]]) }}
<div class="modal-body">
    <div class="text-end">
        @if (module_is_active('AIAssistant'))
            @include('aiassistant::ai.generate_ai_btn', [
                'template_module' => 'add note on appointment',
                'module' => 'VCard',
            ])
        @endif
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <div class="row gutters-xs">
                <div class="col-12">
                    <h6 class="">{{ __('Status') }}</h6>
                </div>
                <div class="col-6">
                    <div class="form-check">
                        <input type="radio" id="pending" class="form-check-input mt-1" name="status"
                            value="pending" @if ($appointment->status == 'pending') checked @endif>
                        {{ Form::label('pending', 'Pending', ['class' => 'custom-control-label ml-4 badge bg-warning p-2 px-3 rounded']) }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check">
                        <input type="radio" id="completed" class="form-check-input mt-1" name="status"
                            value="completed" @if ($appointment->status == 'completed') checked @endif>
                        {{ Form::label('completed', 'Completed', ['class' => 'custom-control-label ml-4  badge bg-success p-2 px-3 rounded']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 form-group mt-4">
            <div class="row gutters-xs">
                <div class="col-12">
                    <h6 class="ml-2">{{ __('Add Note') }}</h6>
                </div>
                <div class="col-12">
                    <textarea class="summernote" id="note" rows="3" name="note">{!! $appointment->note !!}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Save') }}">
</div>
{{ Form::close() }}
<script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
