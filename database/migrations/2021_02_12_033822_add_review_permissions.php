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
            'delete competitors',
            'view insights',
            'create insights',
            'update insights',
            'delete insights',
            'view reviews',
            'create reviews',
            'update reviews',
            'delete reviews',
            'view snapshots',
            'create snapshots',
            'update snapshots',
            'delete snapshots'
        ];

        $this->createPermissions($permissions);
    }
}
