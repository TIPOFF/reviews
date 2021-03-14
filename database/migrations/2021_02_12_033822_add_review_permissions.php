<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddReviewPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view competitors' => ['Owner', 'Executive', 'Staff'],
            'create competitors' => ['Owner', 'Executive'],
            'update competitors' => ['Owner', 'Executive'],
            'view insights' => ['Owner', 'Executive', 'Staff'],
            'view reviews' => ['Owner', 'Executive', 'Staff'],
            'update reviews' => ['Owner', 'Executive'],
            'view snapshots' => ['Owner', 'Executive', 'Staff']
        ];

        $this->createPermissions($permissions);
    }
}
