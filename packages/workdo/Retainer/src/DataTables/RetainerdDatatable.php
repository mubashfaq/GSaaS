<?php

namespace Workdo\Retainer\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\Retainer\Entities\Retainer;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RetainerdDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['retainer_id', 'customer_id', 'status', 'due_amount'];
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('retainer_id', function (Retainer $retainer) {
                $url = route('retainer.show', \Crypt::encrypt($retainer->id));
                $retainerNumber = Retainer::retainerNumberFormat($retainer->retainer_id);
                return '<a href="' . $url . '" class="btn btn-outline-primary">' . $retainerNumber . '</a>';
            })
            ->editColumn('issue_date', function (Retainer $retainer) {
                return company_date_formate($retainer->issue_date);
            })
            ->editColumn('status', function (Retainer $retainer) {
                if ($retainer->status == 0) {
                    $class = 'bg-primary';
                } elseif ($retainer->status == 1) {
                    $class = 'bg-info';
                } elseif ($retainer->status == 2) {
                    $class = 'bg-secondary';
                } elseif ($retainer->status == 3) {
                    $class = 'bg-warning';
                } elseif ($retainer->status == 4) {
                    $class = 'bg-danger';
                }
                return '<span class="badge fix_badges ' . $class . ' p-2 px-3">' . Retainer::$statues[$retainer->status] . '</span>';
            })
            ->filterColumn('status', function ($query, $keyword) {
                if (stripos('Draft', $keyword) !== false) {
                    $query->where('status', 0);
                } elseif (stripos('Open', $keyword) !== false) {
                    $query->orWhere('status', 1);
                } elseif (stripos('Accepted', $keyword) !== false) {
                    $query->orWhere('status', 2);
                } elseif (stripos('Declined', $keyword) !== false) {
                    $query->orWhere('status', 3);
                } elseif (stripos('Paid', $keyword) !== false) {
                    $query->orWhere('status', 4);
                }
            })
            ->addColumn('due_amount', function (Retainer $retainer) {
                return currency_format_with_sym($retainer->getDue());
            });
        if (!\Auth::user()->type != 'Client') {
            $dataTable = $dataTable->editColumn('customer_id',  function ($row) {
                return $row->user_name;
            });
            $rowColumn[] = 'customer_id';
        }
        if (\Laratrust::hasPermission('retainer edit') || \Laratrust::hasPermission('retainer delete') || \Laratrust::hasPermission('retainer show')) {
            $dataTable->addColumn('action', function (Retainer $retainer) {
                return view('retainer::retainer.action', compact('retainer'));
            });

            $rowColumn[] = 'action';
        }
        return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Retainer $model, Request $request): QueryBuilder
    {   
        //  if (Auth::user()->type != 'company') {
        //     $query = $model->join('users', 'retainers.customer_id', '=', 'users.id')
        //         ->where('users.id', Auth::user()->id)->select('retainers.*')
        //         ->where('retainers.workspace', getActiveWorkSpace());
        // } else {
        //     $query = $model->where('workspace', getActiveWorkSpace());
        // }

        // if (!empty($request->customer)) {
        //     $query->where('customer_id', '=', $request->customer);
        // }
        // if (!empty($request->issue_date)) {
        //     $date_range = explode('to', $request->issue_date);
        //     if (count($date_range) == 2) {
        //         $query->whereBetween('issue_date', $date_range);
        //     } else {
        //         $query->where('issue_date', $date_range[0]);
        //     }
        // }

        // if (!empty($request->status)) {

        //     $query->where('status', $request->status);
        // }
        // return $query->with('customers');
        
        //   dd(creatorId());
        /////////////
        if (Auth::user()->type != 'company') {
        $retainer = $model->newQuery()
            ->select('retainers.*', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'retainers.user_id')
            ->where('retainers.user_id', Auth::user()->id)
            ->where('retainers.workspace', getActiveWorkSpace());
        }
        else {
            $retainer = $model->newQuery()
            ->select('retainers.*', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'retainers.user_id')
            ->where('retainers.created_by', creatorId())
            ->where('retainers.workspace', getActiveWorkSpace());
         }
        if (!empty($request->customer)) {
            $retainer->where('user_id', '=', $request->customer);
        }

        if (!empty($request->issue_date)) {
            $date_range = explode('to', $request->issue_date);
            if (count($date_range) == 2) {
                $retainer->whereBetween('issue_date', $date_range);
            } else {
                $retainer->where('issue_date', $date_range[0]);
            }
        }

        if (!empty($request->status)) {
            $retainer->where('status', $request->status);
        }
       
         return $retainer;
        /////////////
        
        
        ///////////
        // $retainer = $model->newQuery()
        //     ->select('retainers.*', 'users.name as user_name')
        //     ->join('users', 'users.id', '=', 'retainers.user_id')
        //     ->where('retainers.created_by', creatorId())
        //     ->where('retainers.workspace', getActiveWorkSpace());

        // if (!empty($request->customer)) {
        //     $retainer->where('user_id', '=', $request->customer);
        // }

        // if (!empty($request->issue_date)) {
        //     $date_range = explode('to', $request->issue_date);
        //     if (count($date_range) == 2) {
        //         $retainer->whereBetween('issue_date', $date_range);
        //     } else {
        //         $retainer->where('issue_date', $date_range[0]);
        //     }
        // }

        // if (!empty($request->status)) {
        //     $retainer->where('status', $request->status);
        // }
        //  return $retainer;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('retainers-table')
            ->columns($this->getColumns())
            ->ajax([
                'data' => 'function(d) {
                    var issue_date = $("input[name=issue_date]").val();
                    d.issue_date = issue_date

                    var customer = $("select[name=customer]").val();
                    d.customer = customer

                    var status = $("select[name=status]").val();
                    d.status = status
                }',
            ])
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
                $("body").on("click", "#applyfilter", function() {

                    if (!$("input[name=issue_date]").val() && !$("select[name=customer]").val() && !$("select[name=status]").val()) {
                        toastrs("Error!", "Please select Atleast One Filter ", "error");
                        return;
                    }

                    $("#retainers-table").DataTable().draw();
                });

                $("body").on("click", "#clearfilter", function() {
                    $("input[name=issue_date]").val("")
                    $("select[name=customer]").val("")
                    $("select[name=status]").val("")
                    $("#retainers-table").DataTable().draw();
                });

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
            "dom" =>  "
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
            Column::make('retainer_id')->title(__('Retainer'))->orderable(false),

        ];
        if (Auth::user()->type != 'client') {
            $column[] = Column::make('customer_id')->title(__('Customer'))->name('users.name');
        }
        $column[] = Column::make('account_type')->title(__('Account Type'));
        $column[] = Column::make('issue_date')->title(__('Issue Date'));
        $column[] = Column::computed('due_amount');
        $column[] = Column::make('status')->title(__('Status'))->searchable(false);
        if (\Laratrust::hasPermission('retainer edit') || \Laratrust::hasPermission('retainer delete') || \Laratrust::hasPermission('retainer show')) {
            $action = [
                Column::computed('action')
                    ->title(__('Action'))
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
        return 'retainers_' . date('YmdHis');
    }
}
