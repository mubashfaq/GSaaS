<?php

namespace Workdo\RestaurantMenu\Database\Seeders;

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
        $module = 'RestaurantMenu';

        $permissions  = [
            'restaurant manage',
            'item manage',
            'offers manage',
            'offers create',
            'offers edit',
            'offers delete',
            'restaurant_customer manage',
            'restaurant_customer create',
            'restaurant_customer edit',
            'restaurant_customer delete',
            'restaurant_system manage',
            'restaurant_items_attributes manage',
            'restaurant_items_attributes create',
            'restaurant_items_attributes edit',
            'restaurant_items_attributes delete',
            'dining_table manage',
            'dining_table create',
            'dining_table edit',
            'dining_table delete',
            'dining_table show',
            'restaurant_category manage',
            'restaurant_category create',
            'restaurant_category edit',
            'restaurant_category delete',
            'restaurant_order manage',
            'restaurant_order delete',
            'restaurant_order show',
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
