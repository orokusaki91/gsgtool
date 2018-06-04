<?php

use Illuminate\Database\Seeder;
use App\USer;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'kuzmic',
            'email' => 'kuzmic@gmail.com',
            'password' => bcrypt('kompjuter'),
            'firstname' => 'Stefan',
            'lastname' => 'Kuzmic',
            'nickname' => 'Kuzma',
            'profile_picture' => 'aaaa',
            'general' => '2018.03.20',
            'service_number' => '000111',
            'birthdate' => '2018.03.20',
            'address_1' => 'Stevana Sremca3',
            'address_2' => 'Knez Mihajlova 14',
            'zip_code' => '34227',
            'city' => 'Batocina',
            'country' => 'RS',
            'canton' => '5',
            'official_address' => '1',
            'post_address' => '0',
            'phone' => '0621008770',
            'mobile' => '0621008770',
            'ahv' => 'Nesto',
            'apartment' => 'Imam',
            'marital_status' => '2',
            'wedding_date' => '2018.03.20',
            'nationality' => 'SR',
            'work_permit' => '3',
            'work_permit_date' => '2018.03.20',
            'acc_type' => '2',
            'iban' => '00115544',
            'number_bank' => '0055566611223',
            'number_post' => '0006545941216',
            'current_job' => '5',
            'spoken_language' => '5,6',
            'auto' => '2',
            'driving_license' => '2',
            'height' => '165',
            'trousers_size' => '3',
            't_shirt_size' => '3',
            'shoe_size' => '40',
        ]);
    }
}
