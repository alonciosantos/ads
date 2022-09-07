<?php

namespace App\Database\Seeds;

use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class UserSeeder extends Seeder
{
    public function run()
    {
        try {
            $this->db->transStart();

            $createHowManyUsers = 500;

            $fabricator = new Fabricator(UserModel::class);
            $users = $fabricator->make($createHowManyUsers);

            $userModel = Factories::models(UserModel::class);

            $totalSteps = count($users);
            $currStep   = 1;

            
            foreach ($users as $user) {

                CLI::showProgress($currStep++, $totalSteps);
                
                $userModel->insert($user);
            }

            // Done, so erase it...
            CLI::showProgress(false);

            $this->db->transComplete();

            echo ("Anunciantes criandos com sucesso");

        } catch (\Throwable $th) {

            print $th;
        }
    }
}
