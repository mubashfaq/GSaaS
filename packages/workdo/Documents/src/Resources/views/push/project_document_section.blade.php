<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ __('Documents') }}
                        ({{ count($documents) }})
                    </h5>
                </div>
                <div class="float-end">
                    @permission('documents create')
                        <p class="text-muted d-sm-flex align-items-center mb-0">
                            <a class="btn btn-sm btn-primary" data-size="lg" data-ajax-popup="true"
                                data-title="{{ __('Create Documents') }}"
                                data-url="{{ route('documents.create', $project_id) }}" data-toggle="tooltip"
                                title="{{ __('Create Document') }}">
                                <i class="ti ti-plus"></i>
                            </a>
                        </p>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-body top-10-scroll">

            <div class="table-responsive">
                <table id="" class="table table-bordered px-2">
                    <thead>
                        <tr>
                            <th>{{ __('Document') }}</th>
                            <th>{{ __('subject') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            @if (Laratrust::hasPermission('documents create') ||
                                    Laratrust::hasPermission('documents show') ||
                                    Laratrust::hasPermission('documents edit') ||
                                    Laratrust::hasPermission('documents delete'))
                                <th>{{ __('Action') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse  ($documents as $document)
                            <tr>
                                <td class="Id">
                                    @permission('documents show')
                                        <a href="{{ route('documents.show', $document->id) }}"
                                            class="btn btn-outline-primary">
                                            {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->document_id) }}
                                        </a>
                                    @else
                                        <a class="btn btn-outline-primary">
                                            {{ Workdo\Documents\Entities\Document::documentNumberFormat($document->document_id) }}
                                        </a>
                                    @endpermission
                                </td>
                                <td>{{ $document->subject ?? '' }}</td>
                                <td>{{ !empty($document->user->name) ? $document->user->name ?? '-' : '-' }}
                                </td>
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

                                @if (Laratrust::hasPermission('documents create') ||
                                        Laratrust::hasPermission('documents show') ||
                                        Laratrust::hasPermission('documents edit') ||
                                        Laratrust::hasPermission('documents delete'))
                                    <td class="Action">
                                        <span>
                                            @permission('documents edit')
                                                <div class="action-btn me-2">
                                                    <a data-size="lg" title="{{ __('Edit') }}"
                                                        data-url="{{ route('documents.edit', [$document->id,'pro_id' => $project_id]) }}"
                                                        data-ajax-popup="true" data-title="{{ __('Edit Document') }}"
                                                        class="bg-info btn btn-sm align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            @endpermission
                                            @permission('documents delete')
                                                <div class="action-btn">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['documents.destroy', $document->id]]) !!}
                                                    <a href="#!" title="{{ __('Delete') }}"
                                                        class="bg-danger btn btn-sm align-items-center show_confirm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <span class="text-white"><i class="ti ti-trash"></i></span>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endpermission
                                        </span>
                                    </td>
                                @endif
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
