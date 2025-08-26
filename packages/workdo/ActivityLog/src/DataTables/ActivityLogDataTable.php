<?php

namespace Workdo\ActivityLog\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rowColumn = ['description', 'user_id','created_at'];
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('description', function (AllActivityLog $activity) {
                return $activity->description . ($activity->user_name ?? '') . '.';
            })
            ->editColumn('user_id', function (AllActivityLog $activity) {
                $html = '';
                $html.= $activity->user_name ?? '--';
                if (!empty($activity->user_id) && $activity->user_id == creatorId()) {
                    $html.= ' ';
                    $html.= '<span class="badge bg-primary">'. $activity->user_type .'</span>';
                }
                return $html;
            })
            ->editColumn('created_at', function (AllActivityLog $activity) {
                return $activity->created_at->diffForHumans();
            });
            if (\Laratrust::hasPermission('activitylog delete')) {
                $dataTable->addColumn('action', function (AllActivityLog $activity) {
                    return view('activity-log::activitylog_action', compact('activity'));
                });
                $rowColumn[] = 'action';
            }
            return $dataTable->rawColumns($rowColumn);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AllActivityLog $model,Request $request): QueryBuilder
    {
        $creatorId = creatorId();
        $getActiveWorkSpace = getActiveWorkSpace();

        $modules = $model->select('module')
                    ->where('created_by', '=', $creatorId)
                    ->where('workspace', '=', $getActiveWorkSpace)
                    ->groupBy('module')
                    ->pluck('module')
                    ->toArray();
        $activitys = $model->join('users', 'all_activity_logs.user_id', '=', 'users.id')
                    ->select('all_activity_logs.*', 'users.name as user_name', 'users.type as user_type')
                    ->where('all_activity_logs.created_by', '=', $creatorId)
                    ->where('all_activity_logs.workspace', '=', $getActiveWorkSpace);
        if ($modules) {
            $activitys = $model->join('users', 'all_activity_logs.user_id', '=', 'users.id')
                        ->select('all_activity_logs.*', 'users.name as user_name', 'users.type as user_type')
                        ->where('all_activity_logs.created_by', '=', $creatorId)
                        ->where('all_activity_logs.workspace', '=', $getActiveWorkSpace)
                        ->where('all_activity_logs.module', '=', $modules[0]);
        }
        if (!empty($request->filter)) {
            $activitys = $model->join('users', 'all_activity_logs.user_id', '=', 'users.id')
                        ->select('all_activity_logs.*', 'users.name as user_name', 'users.type as user_type')
                        ->where('all_activity_logs.created_by', '=', $creatorId)
                        ->where('all_activity_logs.workspace', '=', $getActiveWorkSpace)
                        ->where('all_activity_logs.module', '=', $modules[$request->filter]);
        }
        if (!empty($request->staff) && !empty($request->filter)) {
            $activitys = $model->join('users', 'all_activity_logs.user_id', '=', 'users.id')
                        ->select('all_activity_logs.*', 'users.name as user_name', 'users.type as user_type')
                        ->where('all_activity_logs.created_by', '=', $creatorId)
                        ->where('all_activity_logs.workspace', '=', $getActiveWorkSpace)
                        ->where('all_activity_logs.user_id', '=', $request->staff)
                        ->where('all_activity_logs.module', '=', $modules[$request->filter]);
        }
       return $activitys;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('activity-log-table')
            ->columns($this->getColumns())
            ->ajax([
                'data' => 'function(d) {
                    var staff = $("select[name=staff]").val();
                    d.staff = staff

                    var filter = $("select[name=filter]").val();
                    d.filter = filter
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

                    if (!$("select[name=staff]").val() && !$("select[name=filter]").val()) {
                        toastrs("Error!", "Please select atleast one filter.", "error");
                        return;
                    }

                    $("#activity-log-table").DataTable().draw();
                });

                $("body").on("click", "#clearfilter", function() {
                    $("select[name=staff]").val("")
                    $("select[name=filter]").val(0)
                    $("#activity-log-table").DataTable().draw();
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
        $columns = [
            Column::make('id')->searchable(false)->visible(false)->exportable(false)->printable(false),
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('module')->title(__('Module')),
            Column::make('sub_module')->title(__('Sub Module')),
            Column::make('description')->title(__('Description'))->name('users.name'),
            Column::make('user_id')->title(__('Staff'))->name('users.name','users.type'),
            Column::make('created_at')->title(__('Activity Duration')),
        ];

        if (\Laratrust::hasPermission('activitylog delete')) {
            $columns[] = Column::computed('action')
                        ->title(__('Action'))
                        ->searchable(false)
                        ->orderable(false)
                        ->exportable(false)
                        ->printable(false)
                        ->width(60)
                        
                        ->searchable(false);
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
