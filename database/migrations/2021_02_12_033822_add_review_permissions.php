<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddReviewPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view competitors' => ['Owner', 'Staff'],
            'create competitors' => ['Owner'],
            'update competitors' => ['Owner'],
            'view insights' => ['Owner', 'Staff'],
            'view reviews' => ['Owner', 'Staff'],
            'update reviews' => ['Owner'],
            'view snapshots' => ['Owner', 'Staff']
        ];

        $this->createPermissions($permissions);
    }
}
