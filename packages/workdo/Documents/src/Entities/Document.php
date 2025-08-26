<?php

namespace Workdo\Documents\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class Document extends Model
{
    use HasFactory;
    protected $table = 'document';

    protected $fillable = [
        'subject',
        'user_id',
        'project_id',
        'type',
        'notes',
        'description',
        'additional_description',
        'status',
        'created_by',
        'workspace_id',
    ];


    public static function getDocumetSummary($documents)
    {
        $total = 0;
        if ($documents != null) {
            foreach ($documents as $document) {
                $total += $document->value;
            }
        }
        return currency_format_with_sym($total);
    }

    public static function documentNumberFormat($number, $company_id = null)
    {
        if (!empty($company_id)) {
            $data = !empty(company_setting('documents_prefix', $company_id)) ? company_setting('documents_prefix', $company_id) : '#DOC';
        } else {
            $data = !empty(company_setting('documents_prefix')) ? company_setting('documents_prefix') : '#DOC';
        }
        return $data . sprintf("%05d", $number);
    }

    public function Type()
    {
        return $this->belongsTo(DocumentType::class, 'type');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Project()
    {
        return $this->belongsTo(\Workdo\Taskly\Entities\Project::class, 'project_id');
    }

    public function Attachments()
    {
        return $this->hasMany(DocumentAttechment::class, 'document_id');
    }

    public function Comments()
    {
        return $this->hasMany(DocumentComments::class, 'document_id');
    }

    public function Notes()
    {
        return $this->hasMany(DocumentNote::class, 'document_id');
    }

    public static function status()
    {
        return  [
            'accept',
            'decline',
            'closed',
            'pending'
        ];
    }

    public static function getId($slug = 'document')
    {
        $getId =  DB::table('document')->where('slug', $slug)->where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->max($slug . '_id');
        return ($getId ?? 0) + 1;
    }


    // staff Default data
    public static function GivePermissionToRoles($role_id = null, $rolename = null)
    {
        $staff_permissions = [
            'documents manage',
            'documents show',
            'documents comment create',
            'documents note create',
        ];

        $roles = $role_id == null ? Role::where('name', 'staff')->get() : Role::where('name', 'staff')->where('id', $role_id)->get();
        foreach ($roles as $role) {
            foreach ($staff_permissions as $permission_name) {
                $permission = Permission::where('name', $permission_name)->first();
                if ($permission && !$role->hasPermission($permission_name)) {
                    $role->givePermission($permission);
                }
            }
        }
    }
}
