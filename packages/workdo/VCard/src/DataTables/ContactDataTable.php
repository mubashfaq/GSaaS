<?php

namespace Workdo\VCard\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\VCard\Entities\Business;
use Workdo\VCard\Entities\ContactsDetails;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['business_id', 'message','status'];
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('business_id', function ($row) {
                return $row->business_name;
            })
            ->editColumn('message', function (ContactsDetails $contactsDetails) {
                $url = route('contacts.message', $contactsDetails->id);
                $html = '<a href="#" class="action-item" data-url="' . $url . '" data-ajax-popup="true" data-bs-toggle="tooltip" title="' . __('Message') . '" data-title="' . __('Message') . '"><i class="fa fa-comment"></i></a>';
                return $html;
            })
            ->editColumn('status', function (ContactsDetails $contactsDetails) {
                if ($contactsDetails->status == "pending") {
                    $html = '<span class="badge bg-warning p-2 px-3">' . ucFirst($contactsDetails->status) . '</span>';
                } else {

                    $html = '<span class="badge bg-primary p-2 px-3">' . ucFirst($contactsDetails->status) . '</span>';
                }

                return $html;
            });
        if (\Laratrust::hasPermission('card contact add note') || \Laratrust::hasPermission('card contact delete')) {
            $dataTable->addColumn('action', function (ContactsDetails $contactsDetails) {
                return view('vcard::contacts.action', compact('contactsDetails'));
            });
            $rowColumn[] = 'action';
        }
        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ContactsDetails $model, Request $request): QueryBuilder
    {
        $currentBusiness = Business::currentBusiness();

        $contacts = $model->newQuery()
            ->select('contacts_details.*', 'businesses.title as business_name')
            ->leftJoin('businesses', 'businesses.id', '=', 'contacts_details.business_id')
            ->where('contacts_details.created_by', creatorId())
            ->where('contacts_details.workspace', getActiveWorkSpace());
        if ($request->business_id == '') {
            $contacts = $contacts->where('contacts_details.business_id', $currentBusiness);
        } else {
            $contacts = $contacts->where('contacts_details.business_id', $request->business_id);
        }


        return $contacts;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('contacts-details-table')
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
            Column::make('business_id')->title(__('Business Name'))->name('businesses.title'),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('phone')->title(__('Phone')),
            Column::make('message')->title(__('Message')),
            Column::make('status')->title(__('Status')),
        ];
        if (\Laratrust::hasPermission('card contact add note') || \Laratrust::hasPermission('card contact delete')) {
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
        return 'Contacts_' . date('YmdHis');
    }
}
