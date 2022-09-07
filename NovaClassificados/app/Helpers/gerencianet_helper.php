<?php

use App\Services\gerencianetService;
use CodeIgniter\Config\Factories;

if(!function_exists('reason_charge')){

    function reason_charge(string $status): string
    {
        return Factories::class(gerencianetService::class)->reasonCharge($status);
    }

}

if(!function_exists('user_reached_adverts_limit')){

    function user_reached_adverts_limit(): bool
    {
        return Factories::class(gerencianetService::class)->userReachedAdvertsLimit();
    }

}

if(!function_exists('count_all_user_adverts')){

    function count_all_user_adverts(): int
    {
        return Factories::class(gerencianetService::class)->countAllUserAdverts();
    }

}