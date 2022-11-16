<?php

namespace Lvg\LvgFields\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LvgFieldsDatabaseSeeder extends Seeder
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
            "lvg-fields.view-any",
            "lvg-fields.create",
            "lvg-fields.view",
            "lvg-fields.update",
            "lvg-fields.delete",
            "lvg-fields.restore",
            "lvg-fields.force-delete",
            "lvg-fields.review",
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
