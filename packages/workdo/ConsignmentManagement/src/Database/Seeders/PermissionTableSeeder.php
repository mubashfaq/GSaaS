<?php

namespace Workdo\ConsignmentManagement\Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class PermissionTableSeeder extends Seeder
{
     public function run()
    {
        Model::unguard();
        Artisan::call('cache:clear');
        $module = 'ConsignmentManagement';

        $permissions  = [
            'consignmentmanagement manage',
            'consignment manage',
            'consignment create',
            'consignment edit',
            'consignment delete',
            'consignment show',

            'consignment product manage',
            'consignment product create',
            'consignment product edit',
            'consignment product delete',
            'consignment product show',

            'purchase order manage',
            'purchase order create',
            'purchase order edit',
            'purchase order delete',
            'purchase order show',
            'purchase order convert to Purchase',

            'sale order manage',
            'sale order create',
            'sale order edit',
            'sale order delete',
            'sale order show',
            'sale order convert to invoice',

            'consignment shipping manage',
            'consignment shipping create',
            'consignment shipping edit',
            'consignment shipping delete',
            'consignment shipping show',

            'consignment return manage',
            'consignment return create',
            'consignment return edit',
            'consignment return delete',
            'consignment return show',

            'consignment qualitycontrol manage',
            'consignment qualitycontrol create',
            'consignment qualitycontrol edit',
            'consignment qualitycontrol delete',
            'consignment qualitycontrol show',

            'consignment contract manage',
            'consignment contract create',
            'consignment contract edit',
            'consignment contract delete',

            'consignment compliance manage',
            'consignment compliance create',
            'consignment compliance edit',
            'consignment compliance delete',
        ];

        $company_role = Role::where('name','company')->first();
        foreach ($permissions as $key => $value)
        {
            $check = Permission::where('name',$value)->where('module',$module)->exists();
            if($check == false)
            {
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
                if(!$company_role->hasPermission($value))
                {
                    $company_role->givePermission($permission);
                }
            }
        }
    }
}
