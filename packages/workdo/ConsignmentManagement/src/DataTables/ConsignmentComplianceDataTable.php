<?php

namespace Workdo\ConsignmentManagement\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Workdo\ConsignmentManagement\Entities\ConsignmentCompliance;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ConsignmentComplianceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['status', 'report_date','remarks'];

        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('status', function (ConsignmentCompliance $compliance) {
                if ($compliance->status == 'Compliant')
                {
                    $class = 'bg-primary';
                }
                elseif($compliance->status == 'Non-Compliant')
                {
                    $class = 'bg-danger';
                }
                return '<span class="badge fix_badges '.$class.' p-2 px-3">'. ConsignmentCompliance::$status[$compliance->status] .'</span>';
            })
            ->editColumn('report_date', function (ConsignmentCompliance $compliance) {
                return company_date_formate($compliance->report_date);
            })
            ->editColumn('remarks', function (ConsignmentCompliance $compliance) {
                $remarks = $compliance->remarks;
                if (strlen($remarks) > 25) {
                    return  substr($remarks, 0, 25) . '<span class="moretext">' . substr($remarks, 25) . '</span>' . '<a href="javascript:;" class="moreless-button text-primary">view more...</a>';
                } else {
                    return $remarks;
                }
            });

        if (\Laratrust::hasPermission('consignment compliance edit') ||
            \Laratrust::hasPermission('consignment compliance delete')) {

            $dataTable->addColumn('action', function ($compliance) {
                return view('consignment-management::compliance.action', compact('compliance'));
            });
            $rowColumn[] = 'action';
        }

        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ConsignmentCompliance $model)
    {
        return $model->where('created_by', creatorId())->where('workspace', getActiveWorkSpace());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('consignment-compliance-table')
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
            Column::make('related_entity')->title(__('Related Entity')),
            Column::make('compliance_type')->title(__('Compliance Type')),
            Column::make('status')->title(__('Status')),
            Column::make('report_date')->title(__('Report Date')),
            Column::make('remarks')->title(__('Remarks')),
        ];

        if (\Laratrust::hasPermission('consignment compliance edit') ||
            \Laratrust::hasPermission('consignment compliance delete')) {

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
        return 'Consignment_Compliance_' . date('YmdHis');
    }
}
