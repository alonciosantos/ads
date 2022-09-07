<?php

namespace App\Database\Seeds;

use App\Models\PlanModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        try{
            $this->db->transStart();

            $planModel = Factories::models(PlanModel::class);

            foreach(self::plans() as $plan){

                $planModel->insert($plan);

            }
            
            $this->db->transComplete();
            
            echo("Planos criando com sucesso");

        }catch(\Throwable $th){

            print $th;
        }
       

    }

    private static function plans():array
    {
        return [
            [
                
                'plan_id' => 9337,
                'name' => 'Plano Mensal',
                'recorrence' => 'monthly',
                'adverts' => 10,
                'description' => 'Plano Mensal',
                'value' => 19.90,
                'is_highlighted' => 0,
               
            ],
            [
                
                'plan_id' => 9338,
                'name' => 'Plano Trimestral',
                'recorrence' => 'quarterly',
                'adverts' => 20,
                'description' => 'Plano Trimestral',
                'value' => 55.00,
                'is_highlighted' => 0,
                
            ],
            [
                
                'plan_id' => 9339,
                'name' => 'Plano Semestral',
                'recorrence' => 'semester',
                'adverts' => '30',
                'description' => 'Plano Semestral',
                'value' => 99.90,
                'is_highlighted' => 0,
                
            ],
            [
                
                'plan_id' => 9340,
                'name' => 'Plano Anual',
                'recorrence' => 'yearly',
                'adverts' => NULL,
                'description' => 'Plano Anual',
                'value' => 199.90,
                'is_highlighted' => 1,
                
            ]
        ];
    }
}
