<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddReviewPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
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
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
