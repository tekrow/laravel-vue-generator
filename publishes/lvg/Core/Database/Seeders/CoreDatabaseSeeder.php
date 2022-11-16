<?php

namespace Lvg\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        if (config("lvg.seeder.seed_menu", false)) {
            $this->call(LvgMenuSeeder::class);
        }
    }
}
