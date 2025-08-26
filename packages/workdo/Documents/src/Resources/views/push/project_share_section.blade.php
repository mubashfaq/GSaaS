<div id="tabs-10" class="">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ __('Documents') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="" class="table table-bordered px-2">
                    <thead>
                        <tr>
                            <th>{{ __('Documentss') }}</th>
                            <th>{{ __('subject') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $document)
                            <tr>
                                <td class="Id">
                                    @permission('documents show')
                                        <a href="{{ route('documents.show', $document->id) }}"
                                            class="btn btn-outline-primary">
                                            {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->document_id) }}</a>
                                    @else
                                        <a class="btn btn-outline-primary">
                                            {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->document_id) }}
                                        </a>
                                    @endpermission
                                </td>
                                <td>{{ $document->subject ?? '' }}</td>
                                <td>{{ !empty($document->user->name) ? $document->user->name ?? '-' : '-' }}</td>
                                <td>{{ $document->Type->name }}</td>
                                <td>
                                    @if ($document->status == 'accept')
                                        <span class="status_badge badge bg-primary  p-2 px-3">
                                            {{ __('Accept') }}
                                        </span>
                                    @elseif($document->status == 'decline')
                                        <span class="status_badge badge bg-danger p-2 px-3">
                                            {{ __('Decline') }}
                                        </span>
                                    @elseif($document->status == 'pending')
                                        <span class="status_badge badge bg-warning p-2 px-3">
                                            {{ __('Pending') }}
                                        </span>
                                    @elseif($document->status == 'closed')
                                        <span class="status_badge badge bg-secondary p-2 px-3">
                                            {{ __('Close') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @include('layouts.nodatafound')
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
