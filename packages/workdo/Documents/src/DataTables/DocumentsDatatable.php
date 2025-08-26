<?php

namespace Workdo\Documents\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Workdo\Documents\Entities\Document;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DocumentsDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $columns = ['document_id', 'user_id', 'type', 'status'];
        $dataTable =  (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('document_id', function (Document $document) {
                if (\Laratrust::hasPermission(['documents show'])) {
                    return "<a href='" . route('documents.show', $document->id) . "' class='btn btn-outline-primary'>" . Document::documentNumberFormat($document->document_id) . "</a>";
                } else {
                    return "<a href='!#' class='btn btn-outline-primary'>" . Document::documentNumberFormat($document->document_id) . "</a>";
                }
            })
            ->filterColumn('document_id', function ($query, $keyword) {
                $formattedValue = str_replace(!empty(company_setting('documents_prefix')) ? company_setting('documents_prefix') : '#DOC', '', $keyword);
                $query->where('document_id', $formattedValue);
            })
            ->editColumn('user_id', function (Document $document) {
                return $document->user_name ?? '';
            })
            ->editColumn('type', function (Document $document) {
                return $document->document_type ?? '';
            })
            ->editColumn('status', function (Document $document) {
                switch ($document->status) {
                    case 'accept':
                        $html = '<span class="status_badge badge bg-primary p-2 px-3">' . __('Accept') . '</span>';
                        break;
                    case 'decline':
                        $html = '<span class="status_badge badge bg-danger p-2 px-3">' . __('Decline') . '</span>';
                        break;
                    case 'pending':
                        $html = '<span class="status_badge badge bg-warning p-2 px-3">' . __('Pending') . '</span>';
                        break;
                    case 'closed':
                        $html = '<span class="status_badge badge bg-secondary p-2 px-3">' . __('Close') . '</span>';
                        break;
                    default:
                        $html = '';
                }
                return $html;
            });

        if (module_is_active('Taskly')) {
            $columns[] = 'project_id';
            $dataTable->addColumn('project_id', function (Document $document) {
                return $document->projects_name ?? '';
            });
        }
        if (\Laratrust::hasPermission(['documents create', 'documents show', 'documents edit', 'documents delete'])) {
            $columns[] = 'action';
            $dataTable->addColumn('action', function (Document $document) {
                return view('documents::documents.action', compact('document'));
            });
        }
        return $dataTable->rawColumns($columns);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Document $model): QueryBuilder
    {
        if (module_is_active('Taskly')) {
            $query = $model->where('document.slug', 'document')->where('document.created_by', creatorId())->where('document.workspace_id', getActiveWorkSpace());
            $query->join('documents_types', 'documents_types.id', '=', 'document.type')
                ->leftJoin('users', 'users.id', '=', 'document.user_id')
                ->leftjoin('projects', 'projects.id', '=', 'document.project_id')
                ->select('document.*','documents_types.name as document_type','projects.name as projects_name', 'users.name as user_name',DB::raw('CASE WHEN document.user_id = 0 THEN "-" ELSE users.name END as user_name'),
                DB::raw('CASE WHEN document.project_id = 0 THEN "-" ELSE COALESCE(projects.name, "-") END as projects_name'));
                $query->get();
            return $query;
        }else
        {
            $query = $model->where('document.slug', 'document')->where('document.created_by', creatorId())->where('document.workspace_id', getActiveWorkSpace());
            $query->join('documents_types', 'documents_types.id', '=', 'document.type')
                ->leftJoin('users', 'users.id', '=', 'document.user_id')
                ->select('document.*','documents_types.name as document_type',DB::raw('CASE WHEN document.user_id = 0 THEN "-" ELSE users.name END as user_name'),);
                $query->get();
            return $query;
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('document-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
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
            Column::make('document_id')->title(__('Document')),
            Column::make('subject')->title(__('subject')),
            Column::make('user_id')->title(__('User'))->name('users.name'),
            Column::make('type')->title(__('Type'))->name('documents_types.name'),
            Column::make('status')->title(__('Status')),
        ];
        if (module_is_active('Taskly')) {
            array_splice($columns, 4, 0, [Column::make('project_id')->title(__('Project'))]);
        }
        if (\Laratrust::hasPermission(['documents create', 'documents show', 'documents edit', 'documents delete'])) {
            $columns[] = Column::computed('action')->exportable(false)->printable(false)->width(60)->title(__('Action'));
        }
        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Documents' . date('YmdHis');
    }
}
