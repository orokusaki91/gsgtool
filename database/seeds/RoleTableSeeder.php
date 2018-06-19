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
            'label' => 'admin'
    	]);
    	Role::create([
    		'role_name' => 'Main Organizer',
            'label' => 'main_organizer'
    	]);
    	Role::create([
    		'role_name' => 'Detective',
            'label' => 'detective'
    	]);
    	Role::create([
    		'role_name' => 'Security',
            'label' => 'security'
    	]);
    	Role::create([
    		'role_name' => 'Guard',
            'label' => 'guard'
    	]);
    	Role::create([
    		'role_name' => 'Client',
            'label' => 'client'
    	]);
    	Role::create([
    		'role_name' => 'Partner',
            'label' => 'partner'
    	]);
    }
}
