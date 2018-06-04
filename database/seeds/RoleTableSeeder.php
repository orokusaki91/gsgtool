<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Role::create([
    		'role_name' => 'Admin',
    	]);
    	Role::create([
    		'role_name' => 'Main Organizer',
    	]);
    	Role::create([
    		'role_name' => 'Detective',
    	]);
    	Role::create([
    		'role_name' => 'Security',
    	]);
    	Role::create([
    		'role_name' => 'Guard',
    	]);
    	Role::create([
    		'role_name' => 'Client',
    	]);
    	Role::create([
    		'role_name' => 'Partner',
    	]);
    }
}
