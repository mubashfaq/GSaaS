<?php

namespace Workdo\ConsignmentManagement\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Workdo\ConsignmentManagement\Entities\PurchaseOrder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PurchaseOrderDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['commission', 'totalamount' , 'taxamount' , 'date' , 'consignment_id' , 'vendor_id'];

        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('commission', function (PurchaseOrder $purchaseOrder) {
                return isset($purchaseOrder->commission) ? currency_format_with_sym($purchaseOrder->commission) : '-';
            })
            ->editColumn('totalamount', function (PurchaseOrder $purchaseOrder) {
                return isset($purchaseOrder->totalamount) ? currency_format_with_sym($purchaseOrder->totalamount) : '-';
            })
            ->editColumn('taxamount', function (PurchaseOrder $purchaseOrder) {
                return isset($purchaseOrder->taxamount) ? currency_format_with_sym($purchaseOrder->taxamount) : '-';
            })
            ->editColumn('date', function (PurchaseOrder $purchaseOrder) {
                return isset($purchaseOrder->date) ? company_date_formate($purchaseOrder->date) : '-';
            })
            ->filterColumn('purchase_orders.date', function ($query, $keyword) {
                try {
                    if (\Carbon\Carbon::hasFormat($keyword, 'd-m-Y')) {
                        // Full date 'd-m-Y'
                        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $keyword)->format('Y-m-d');
                        return $query->where('date', 'LIKE', "%$date%");
                    } elseif (\Carbon\Carbon::hasFormat($keyword, 'm-Y')) {
                        // Month-Year 'm-Y'
                        $date = \Carbon\Carbon::createFromFormat('m-Y', $keyword)->format('Y-m');
                        return $query->where('date', 'LIKE', "%$date%");
                    } elseif (\Carbon\Carbon::hasFormat($keyword, 'd-m')) {
                        // Day-Month 'd-m'
                        $date = \Carbon\Carbon::createFromFormat('d-m', $keyword)->format('m-d');
                        return $query->where('date', 'LIKE', "%$date%");
                    } else {
                        // Separate day, month, and year checks
                        $hasDay = false;
                        $hasMonth = false;
                        $hasYear = false;

                        if (\Carbon\Carbon::hasFormat($keyword, 'd') && strlen($keyword) <= 2) {
                            $day = \Carbon\Carbon::createFromFormat('d', $keyword)->format('d');
                            $query->whereRaw('DAY(date) = ?', [$day]);
                            $hasDay = true;
                        }
                        if (\Carbon\Carbon::hasFormat($keyword, 'm') && strlen($keyword) <= 2) {
                            $month = \Carbon\Carbon::createFromFormat('m', $keyword)->format('m');
                            $query->orWhereRaw('MONTH(date) = ?', [$month]);
                            $hasMonth = true;
                        }
                        if (preg_match('/^\d{4}$/', $keyword)) {
                            $year = \Carbon\Carbon::createFromFormat('Y', $keyword)->format('Y');
                            $query->orWhereRaw('YEAR(date) = ?', [$year]);
                            $hasYear = true;
                        }

                        // Combine conditions to ensure proper logic
                        if ($hasDay || $hasMonth || $hasYear) {
                            return $query;
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Invalid date format: ' . $keyword);
                }
            })
            ->editColumn('consignment_id', function (PurchaseOrder $purchaseOrder) {
                return $purchaseOrder->consignments_name ?? '-';
            })
            ->editColumn('vendor_id', function (PurchaseOrder $purchaseOrder) {
                return $purchaseOrder->vendors_name ?? '-';
            });


        if (\Laratrust::hasPermission('purchase order edit') ||
            \Laratrust::hasPermission('purchase order delete') ||
            \Laratrust::hasPermission('purchase order show') ||
            \Laratrust::hasPermission('purchase order convert to Purchase')) {

            $dataTable->addColumn('action', function ($purchaseOrder) {
                return view('consignment-management::purchase.action', compact('purchaseOrder'));
            });
            $rowColumn[] = 'action';
        }

        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PurchaseOrder $model)
    {
        $purchaseOrders = $model->select('purchase_orders.*', 'consignments.title as consignments_name', 'consignments.taxamount', 'users.name as vendors_name')
            ->leftjoin('consignments', 'purchase_orders.consignment_id', '=', 'consignments.id')
            ->leftjoin('users', 'purchase_orders.vendor_id', '=', 'users.id')
            ->where('purchase_orders.created_by', creatorId())
            ->where('purchase_orders.workspace_id', getActiveWorkSpace());
        return $purchaseOrders;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('purchaseorder-table')
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
            Column::make('consignment_id')->title(__('Consignment'))->name('consignments.title'),
            Column::make('vendor_id')->title(__('vendor'))->name('users.name'),
            Column::make('date')->title(__('date')),
            Column::make('commission')->title(__('commission')),
            Column::make('taxamount')->title(__('Tax Amount'))->name('consignments.taxamount'),
            Column::make('totalamount')->title(__('Total Amount')),
        ];

        if (\Laratrust::hasPermission('purchase order edit') ||
            \Laratrust::hasPermission('purchase order delete') ||
            \Laratrust::hasPermission('purchase order show') ||
            \Laratrust::hasPermission('purchase order convert to Purchase')) {

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
        return 'Consignment_PurchaseOrder_' . date('YmdHis');
    }
}
