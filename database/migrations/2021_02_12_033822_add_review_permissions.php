<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddReviewPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view competitors',
            'create competitors',
            'update competitors',
            'view insights',
            'view reviews',
            'update reviews',
            'view snapshots'
        ];

        $this->createPermissions($permissions);
    }
}
