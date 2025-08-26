<?php

namespace Workdo\FindGoogleLeads\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\FindGoogleLeads\Entities\GoogleLeadContact;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GoogleLeadContactDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['phone_no','address','website'];
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('phone_no', function (GoogleLeadContact $leadContant) {
                if (!empty($leadContant->phone_no)) {
                    $html=$leadContant->phone_no;
                } else {
                    $html = '-';
                }
                return $html;

            })
            ->editColumn('website', function (GoogleLeadContact $leadContant) {
                if (!empty($leadContant->website)) {
                    $html=$leadContant->website;
                } else {
                    $html = '-';
                }
                return $html;

            })
            ->editColumn('address', function (GoogleLeadContact $leadContant) {
                if (!empty($leadContant->address)) {
                    $addressChunks = str_split($leadContant->address, 10 * 6); // assuming an average word length of 6 characters
                    foreach ($addressChunks as $chunk) {
                        $html = $chunk;
                    }
                } else {
                    $html = '-';
                }
                return $html;

            });

        if (\Laratrust::hasPermission('findgooglelead contact convert') || \Laratrust::hasPermission('findgooglelead contact delete')) {
            $dataTable->addColumn('action', function (GoogleLeadContact $leadContant) {
                return view('findgoogleleads::lead.contact_action', compact('leadContant'));
            });
            $rowColumn[] = 'action';
        }
        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(GoogleLeadContact $model): QueryBuilder
    {
        $leadContact = $model->newQuery()
            ->where('founded_lead_id', $this->leadId);
        return $leadContact;

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('google-leads-contact-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
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
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderab(false),
            Column::make('name')->title(__('Name')),
            Column::make('phone_no')->title(__('Phone')),
            Column::make('website')->title(__('Website')),
            Column::make('address')->title(__('Address'))
        ];
        if (\Laratrust::hasPermission('findgooglelead contact convert') || \Laratrust::hasPermission('findgooglelead contact delete')) {
            $action = [
                Column::computed('action')->title(__('Action'))
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
        return 'Lead_Contact_' . date('YmdHis');
    }
}
