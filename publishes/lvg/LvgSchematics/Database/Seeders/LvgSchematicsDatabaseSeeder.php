<?php

namespace Lvg\LvgSchematics\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LvgSchematicsDatabaseSeeder extends Seeder
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
            "lvg-schematics.view-any",
            "lvg-schematics.create",
            "lvg-schematics.view",
            "lvg-schematics.update",
            "lvg-schematics.delete",
            "lvg-schematics.restore",
            "lvg-schematics.force-delete",
            "lvg-schematics.review",
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
