<?php

namespace Workdo\ConsignmentManagement\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Workdo\ConsignmentManagement\Entities\ConsignmentContract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ConsignmentContractDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['party_a', 'party_b' ,'contract_type','start_date','end_date','terms_and_conditions'];

        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('party_a', function (ConsignmentContract $contract) {
                return !empty($contract->customer) ? $contract->customer->name : '';
            })
            ->filterColumn('party_a', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->editColumn('party_b', function (ConsignmentContract $contract) {
                return !empty($contract->company) ? $contract->company->name : '';
            })
            ->filterColumn('party_b', function ($query, $keyword) {
                $query->whereHas('company', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })
            ->editColumn('contract_type', function (ConsignmentContract $contract) {
                if ($contract->contract_type == 'Supply')
                {
                    $class = 'bg-info';
                }
                elseif($contract->contract_type == 'Purchase')
                {
                    $class = 'bg-primary';
                }
                return '<span class="badge fix_badges '.$class.' p-2 px-3">'. ConsignmentContract::$contractType[$contract->contract_type] .'</span>';
            })
            ->editColumn('start_date', function (ConsignmentContract $contract) {
                return company_date_formate($contract->start_date);
            })
            ->editColumn('end_date', function (ConsignmentContract $contract) {
                return company_date_formate($contract->end_date);
            })
            ->editColumn('terms_and_conditions', function (ConsignmentContract $contract) {
                $terms_and_conditions = $contract->terms_and_conditions;
                if (strlen($terms_and_conditions) > 25) {
                    return  substr($terms_and_conditions, 0, 25) . '<span class="moretext">' . substr($terms_and_conditions, 25) . '</span>' . '<a href="javascript:;" class="moreless-button text-primary">view more...</a>';
                } else {
                    return $terms_and_conditions;
                }
            });

        if (\Laratrust::hasPermission('consignment contract edit') ||
            \Laratrust::hasPermission('consignment contract delete')) {

            $dataTable->addColumn('action', function ($contract) {
                return view('consignment-management::contract.action', compact('contract'));
            });
            $rowColumn[] = 'action';
        }

        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ConsignmentContract $model)
    {
        return $model->with(['customer','company'])->where('created_by', creatorId())->where('workspace', getActiveWorkSpace());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('consignment-contract-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>',
                ],
                'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'),
                "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries'),
            ])
            ->initComplete('function() {
                var table = this;
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');

        $exportButtonConfig = [
            'extend' => 'collection',
            'className' => 'btn btn-light-secondary dropdown-toggle',
            'text' => '<i class="ti ti-download me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Export"></i>',
            'buttons' => [
                [
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print me-2"></i> ' . __('Print'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
                [
                    'extend' => 'csv',
                    'text' => '<i class="fas fa-file-csv me-2"></i> ' . __('CSV'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
                [
                    'extend' => 'excel',
                    'text' => '<i class="fas fa-file-excel me-2"></i> ' . __('Excel'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
            ],
        ];

        $buttonsConfig = array_merge([
            $exportButtonConfig,
            [
                'extend' => 'reset',
                'className' => 'btn btn-light-danger',
            ],
            [
                'extend' => 'reload',
                'className' => 'btn btn-light-warning',
            ],
        ]);

        $dataTable->parameters([
            "dom" => "
        <'dataTable-top'<'dataTable-dropdown page-dropdown'l><'dataTable-botton table-btn dataTable-search tb-search  d-flex justify-content-end gap-2'Bf>>
        <'dataTable-container'<'col-sm-12'tr>>
        <'dataTable-bottom row'<'col-5'i><'col-7'p>>",
            'buttons' => $buttonsConfig,
            "drawCallback" => 'function( settings ) {
                var tooltipTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=tooltip]")
                  );
                  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                  });
                  var popoverTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=popover]")
                  );
                  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                  });
                  var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                  var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                  });
            }',
        ]);

        $dataTable->language([
            'buttons' => [
                'create' => __('Create'),
                'export' => __('Export'),
                'print' => __('Print'),
                'reset' => __('Reset'),
                'reload' => __('Reload'),
                'excel' => __('Excel'),
                'csv' => __('CSV'),
            ],
        ]);

        return $dataTable;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $column = [
            Column::make('id')->searchable(false)->visible(false)->exportable(false)->printable(false),
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('party_a')->title(__('Customers')),
            Column::make('party_b')->title(__('Company')),
            Column::make('contract_type')->title(__('Contract Type')),
            Column::make('start_date')->title(__('Start Date')),
            Column::make('end_date')->title(__('End Date')),
            Column::make('terms_and_conditions')->title(__('Terms and Conditions')),
        ];

        if (\Laratrust::hasPermission('consignment contract edit') ||
            \Laratrust::hasPermission('consignment contract delete')) {

            $action = [
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    
            ];
            $column = array_merge($column, $action);
        }
        return $column;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Consignment_Contract_' . date('YmdHis');
    }
}
