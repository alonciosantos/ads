<?php

use App\Models\UserModel;
use CodeIgniter\Config\Factories;

if(!function_exists('get_superadmin')){

    function get_superadmin()
    {
        // carregar o helper 'superadmin' no baseController em  protected $helpers ='from','number'
    return Factories::models(UserModel::class)->getSuperadmin();
}
}


