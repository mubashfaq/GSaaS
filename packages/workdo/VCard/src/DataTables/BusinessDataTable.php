<?php

namespace Workdo\VCard\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\VCard\Entities\Business;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BusinessDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['logo', 'status', 'title', 'created_at',];
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('logo', function (Business $business) {
                if (check_file($business->logo) == false) {
                    $path = asset('packages/workdo/VCard/src/Resources/assets/custom/img/placeholder-image21.jpg');
                } else {
                    $path = get_file($business->logo);
                }

                $html = '<a href="' . $path . '" target="_blank">
                            <img src="' . $path . '" class="rounded border-2 border border-primary" width="45px" height="45px" id="blah3">
                         </a>';

                return $html;
            })
            ->editColumn('title', function (Business $business) {

                $path = route('get.vcard', $business->slug);

                $html = '<a href="' . $path . '" style="min-width: 180px;" target="_blank">
                            ' . $business->title . '
                         </a>';

                return $html;
            })
            ->editColumn('created_at', function (Business $business) {
                $now = convertToTargetTimezone($business->created_at); 
                return $now;
            })
            ->editColumn('status', function (Business $business) {
                if ($business->status == "locked") {
                    $html = '<span class="badge bg-danger p-2 px-3">' . ucFirst($business->status) . '</span>';
                } else {
                    $html = '<span class="badge bg-primary p-2 px-3">' . ucFirst($business->status) . '</span>';
                }

                return $html;
            });
        if (
            \Laratrust::hasPermission('card appointment calendar') || \Laratrust::hasPermission('card contact manage') || \Laratrust::hasPermission('business edit') || \Laratrust::hasPermission('business delete')
        ) {
            $dataTable->addColumn('action', function (Business $business) {
                return view('vcard::business.action', compact('business'));
            });
            $rowColumn[] = 'action';
        }

        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Business $model): QueryBuilder
    {
        $business = $model->newQuery()
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace());

        return $business;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('businesses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => "_MENU_" . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'),
                "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')
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
            }'
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
            ]
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
            Column::make('logo')->title(__('Business Logo'))->searchable(false)->orderable(false),
            Column::make('title')->title(__('Business Name')),
            Column::make('status')->title(__('Status')),
            Column::make('created_at')->title(__('Generate Date')),
        ];
        if (
            \Laratrust::hasPermission('card appointment calendar') || \Laratrust::hasPermission('card contact manage') || \Laratrust::hasPermission('business edit') || \Laratrust::hasPermission('business delete')
        ) {
            $action = [
                Column::computed('action')->title(__('Operations'))
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
        return 'Business_' . date('YmdHis');
    }
}
