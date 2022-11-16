<?php

namespace Lvg\LvgMenus\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LvgMenusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions Seeder
        $perms = [
            "lvg-menus.view-any",
            "lvg-menus.create",
            "lvg-menus.view",
            "lvg-menus.update",
            "lvg-menus.delete",
            "lvg-menus.restore",
            "lvg-menus.force-delete",
            "lvg-menus.review",
        ];
        try {
            \Tekrow\Lvg\Helpers\Permissions::seedPermissions($perms);
        } catch (\Throwable $e) {
            \Log::info($e);
            abort($e->getMessage());
        }

        // $this->call("OthersTableSeeder");
    }
}
