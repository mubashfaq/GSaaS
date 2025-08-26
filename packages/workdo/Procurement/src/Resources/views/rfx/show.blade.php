@extends('layouts.main')
@section('page-title')
    {{ __('RFx Details') }}
@endsection
@section('page-action')
    <div>
        @permission('rfx edit')
            <a href="{{ route('rfx.edit', $rfx->id) }}" data-size="md" data-title="{{ __('Edit RFx') }}" data-bs-toggle="tooltip"
                title="" class="btn btn-sm btn-info" data-bs-original-title="{{ __('Edit') }}">
                <i class="ti ti-pencil text-white"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('page-breadcrumb')
    {{ __('Manage RFx') }},
    {{ __('RFx Details') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>{{ __('RFx Details') }}</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ __('RFx Title') }}</td>
                                    <td class="">{{ $rfx->title }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('RFx Category') }}</td>
                                    <td class="">{{ !empty($rfx->category) ? $rfx->categories->name : '-' }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('RFx Type') }}</td>
                                    <td class="">{{ !empty($rfx->rfx_type) ? $rfx->rfx_type : '-' }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Positions') }}</td>
                                    <td class="">{{ $rfx->position }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Status') }}</td>
                                    <td class="">
                                        @if ($rfx->status == 'active')
                                            <span
                                                class="p-2 px-3 badge bg-success">{{ \Workdo\Procurement\Entities\Rfx::$status[$rfx->status] }}</span>
                                        @else
                                            <span
                                                class="p-2 px-3 badge bg-danger">{{ \Workdo\Procurement\Entities\Rfx::$status[$rfx->status] }}</span>
                                        @endif
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Budget From') }}</td>
                                    <td class="">{{ currency_format_with_sym($rfx->budget_from) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Budget To') }}</td>
                                    <td class="">{{ currency_format_with_sym($rfx->budget_to) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Created Date') }}</td>
                                    <td class="">{{ company_date_formate($rfx->created_at) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Start Date') }}</td>
                                    <td class="">{{ company_date_formate($rfx->start_date) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('End Date') }}</td>
                                    <td class="">{{ company_date_formate($rfx->end_date) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Skill') }}</td>
                                    <td class="">
                                        @foreach ($rfx->skill as $skill)
                                            <span class="p-2 px-3 badge bg-primary">{{ $skill }}</span>
                                        @endforeach
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Location') }}</td>
                                    <td class="">{{ !empty($rfx->location) ? $rfx->location : '-' }}</td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Billing Type') }}</td>
                                    <td class="">{{ !empty($rfx->billing_type) ? ucFirst($rfx->billing_type) : '-' }}
                                    </td>
                                    <td colspan="2"></td>
                                </tr>

                            </tbody>
                            @if ($rfx->billing_type == 'items')
                                <thead>
                                    <tr>
                                        <th>{{ __('Items') }}</th>
                                        <th colspan="3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>{{ __('Item Type') }}</th>
                                        <th>{{ __('Item Name') }}</th>
                                        <th>{{ __('Description') }}</th>
                                    </tr>
                                    @foreach ($rfxItemData as $rfxItem)
                                        <tr>
                                            <td>{{ ucfirst($rfxItem->product_type) }}</td>
                                            <td>{{ !empty($rfxItem->product_id) ? $rfxItem->product()->name : '' }}</td>
                                            <td>{{ $rfxItem->product_description }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @elseif($rfx->billing_type == 'rfx')
                                <thead>
                                    <tr>
                                        <th>{{ __('RFx`s Task') }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>{{ __('Task') }}</th>
                                        <th colspan="2">{{ __('Description') }}</th>
                                    </tr>
                                    @foreach ($rfxItemData as $rfxItem)
                                        <tr>
                                            <td>{{ $rfxItem->rfx_task }}</td>
                                            <td>{{ $rfxItem->rfx_description }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-fluid">
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">

                            @if ($rfx->applicant)
                                <div class="col-6">
                                    <h6>{{ __('Need to ask ?') }}</h6>
                                    <ul class="">
                                        @foreach ($rfx->applicant as $applicant)
                                            <li>{{ ucfirst($applicant) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($rfx->visibility))
                                <div class="col-6">
                                    <h6>{{ __('Need to show option ?') }}</h6>
                                    <ul class="">
                                        @foreach ($rfx->visibility as $visibility)
                                            <li>{{ ucfirst($visibility) }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif

                            @if (count($rfx->questions()) > 0)
                                <div class="col-12">
                                    <h6>{{ __('Custom Question') }}</h6>
                                    <ul class="">
                                        @foreach ($rfx->questions() as $question)
                                            <li>{{ $question->question }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="row ">
                            <div class="col-12 mt-3">
                                <h6>{{ __('RFx Description') }}</h6>
                                {!! $rfx->description !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <h6>{{ __('RFx Requirement') }}</h6>
                                {!! $rfx->requirement !!}
                            </div>
                        </div>
                        @if (!empty($rfx->terms_and_conditions))
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <h6>{{ __('Terms And Conditions') }}</h6>
                                    {!! $rfx->terms_and_conditions !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
