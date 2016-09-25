<?php

use Illuminate\Database\Seeder;
use App\Role;

/**
 * Seed roles table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = ['admin', 'user'];
        foreach ($roles as $role) {
            $currentRole = new Role();
            $currentRole->name = $role;
            $currentRole->display_name = ucfirst($role);
            $currentRole->save();
        }
    }
}
