<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;
use PhpParser\Node\Stmt\TryCatch;

class SuperadminSeeder extends Seeder
{
    public function run()
    {
        //

            try{

                $this->db->transStart();

                $user = new User([
                    'username'          => 'Manager',
                    //'name'            => 'Aloncio', alteraremos depois
                    //'last_name'       => 'Santos',
                    'email'             => 'manager@manager.com',
                    'password'          => '12345678',
                    'email_verified_at '=> date('Y-m-d H:i:s'), //ja criamos com email verificado (email)

                ]);

                $userID =  Factories::models(UserModel::class)->insert($user);
               
                $this->createSuperadmin($userID);

                $this->db->transComplete();

                echo "Superadmin criado com sucesso";

            }catch(\Exception $e){

                print $e->getMessage();

            }
        }
     private function createSuperadmin(int $userID)
     {
        $db = \config\Database::connect();

        $superadmin = [
            'user_id' => $userID
        ];
        $db->table('superadmins')->insert($superadmin);
     }
}
