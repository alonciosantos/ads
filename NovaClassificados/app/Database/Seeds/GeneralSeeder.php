<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GeneralSeeder extends Seeder
{
    public function run()
    {

        //esta seeder executa todas as seeder colocadas aqui dentro
        
        $this->call(SuperadminSeeder::class);
        $this->call(PlanSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(UsersBackSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(AdvertsWithImagesSeeder::class);
        //$this->call(AdvertSeeder::class);
    }
}
