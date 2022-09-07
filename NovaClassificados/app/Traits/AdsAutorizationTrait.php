<?php

namespace App\Traits;

use \Fluent\Auth\Config\Services;


trait AdsAutorizationTrait
{
    public function isSuperadmin():bool
    {

        $builder = Services::auth()
        ->getProvider() // pega o noome do model
        ->instance() // pega a instancia de Entity/User.php
        ->join('superadmins','superadmins.user_id = users.id') // consuta o 'user_id' de 'superusuario' com o 'user_id' de 'users'
        ->where('superadmins.user_id', $this->id); // aqui compara se existe o user_id na tabela de useradmins

        return $builder->first() !== null;  //pega o primeiro resultado e verifica se e nuloou não
       

    }
}