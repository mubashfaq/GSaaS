<?php

namespace Workdo\Documents\Listeners;

use App\Events\GivePermissionToRole;
use Workdo\Newspaper\Entities\NewspaperUtility;

class GiveRoleToPermission
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GivePermissionToRole $event)
    {
        $role_id = $event->role_id;
        $rolename = $event->rolename;
        $user_module = $event->user_module;
        if (!empty($user_module)) {
            if (in_array("Newspaper", $user_module)) {
                NewspaperUtility::GivePermissionToRoles($role_id, $rolename);
            }
        }
    }
}
