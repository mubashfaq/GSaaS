<?php

namespace Workdo\Documents\Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Workdo\Documents\Entities\Document;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        Artisan::call('cache:clear');
        $module = 'Documents';

        $permissions  = [
            'documents manage',
            'documents create',
            'documents edit',
            'documents delete',
            'documents show',

            'documents type manage',
            'documents type create',
            'documents type edit',
            'documents type delete',

            'documents comment create',
            'documents comment delete',

            'documents note create',
            'documents note delete',
        ];

        $company_role = Role::where('name', 'company')->first();
        foreach ($permissions as $key => $value) {
            $check = Permission::where('name', $value)->where('module', $module)->exists();
            if ($check == false) {
                $permission = Permission::create(
                    [
                        'name' => $value,
                        'guard_name' => 'web',
                        'module' => $module,
                        'created_by' => 0,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                );
                if (!$company_role->hasPermission($value)) {
                    $company_role->givePermission($permission);
                }
            }
        }

        Document::GivePermissionToRoles();
    }
}
