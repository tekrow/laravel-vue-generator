<?php

namespace Lvg\LvgRelationships\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LvgRelationshipsDatabaseSeeder extends Seeder
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
            "lvg-relationships.view-any",
            "lvg-relationships.create",
            "lvg-relationships.view",
            "lvg-relationships.update",
            "lvg-relationships.delete",
            "lvg-relationships.restore",
            "lvg-relationships.force-delete",
            "lvg-relationships.review",
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
