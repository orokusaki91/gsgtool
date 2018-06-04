<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDO;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'imprint'
            ]
        ]);
    }

    public function index()
    {
        return view('pages.home.index');
    }

    public function imprint()
    {
        return view('pages.home.imprint');
    }

    public function db()
    {
        $arr = [
            'user_id' => 'id',
            'user_username' => 'username',
            'user_password' => bcrypt('gsgtool'),
            'user_firstname' => 'firstname',
            'user_lastname' => 'lastname',
            'user_rufname' => 'id',
            'user_type' => 'id',
            'user_personal' => 'id',
            'user_dienst' => 'id',
            'user_birthdate' => 'birthdate',
            'user_address1' => 'address_1',
            'user_address2' => 'address_2',
            'user_postno' => 'id',
            'user_city' => 'city',
            'user_country' => 'country',
            'user_canton' => 'canton',
            'user_offaddress' => 'id',
            'user_postaddress' => 'id',
            'user_phone' => 'phone',
            'user_mobile' => 'mobile',
            'user_mail' => 'email',
            'user_ahv' => 'ahv',
            'user_rente' => 'id',
            'user_marige' => 'id',
            'user_national' => 'id',
            'user_workpermit' => 'id',
            'user_workpermit_date' => 'id',
            'user_acctype' => 'id',
            'user_iban' => 'id',
            'user_konto' => 'id',
            'user_postkonto' => 'id',
            'user_job' => 'id',
            'user_langsel' => 'id',
            'user_driver_licence' => 'id',
            'user_auto' => 'id',
            'user_publictr' => 'id',
            'user_height' => 'id',
            'user_pants' => 'id',
            'user_shirt' => 'id',
            'user_shoe' => 'id',
            'user_archived' => 'id',
            'clients_list' => 'id',
            'user_otherdate' => 'id',
        ];
        $conn = new PDO('mysql:dbname=gsg;host=127.0.0.1', 'homestead', 'secret');

        $query = $conn->query('select * from user');

        $rows = $query->fetchAll();

        $user = new User;

        foreach($rows as $row){
            foreach($row as $k=>$v){
                if(array_key_exists($k, $arr)){
                    $key = $arr[$k];
                    $user->$key = $v;
                }
            }
        }
        dd($user);
    }
}
