<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        try {
            $this->db->transStart();

            foreach (self::subscriptions() as $subscription) {
                $this->db->table('subscriptions')->insert($subscription);
            }

            //print_r(self::subscriptions());
           // exit;
            $this->db->transComplete();

            echo 'Assinaturas criadas com sucesso!';
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            print $th;
        }
    }

    private static function subscriptions(): array
    {
        $subscriptions = array(
            array(
                'id' => '1',
                'user_id' => '2', 
                'subscription_id' => '65906', 
                'plan_id' => '9337', 
                'charge_not_paid' => NULL, 
                'status' => 'active', 
                'is_paid' => '1', 
                'valid_until' => '2022-08-21 13:35:07', 
                'reason_charge' => 'Cobrança paga manualmente', 
                'history' => 'a:12:{s:15:"subscription_id";i:65906;s:5:"value";i:1990;s:6:"status";s:6:"active";s:9:"custom_id";N;s:16:"notification_url";N;s:14:"payment_method";s:14:"banking_billet";s:14:"next_execution";s:10:"2022-09-14";s:14:"next_expire_at";s:10:"2022-09-26";s:4:"plan";a:4:{s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:8:"interval";i:1;s:7:"repeats";N;}s:11:"occurrences";i:1;s:10:"created_at";s:19:"2022-08-21 12:33:37";s:7:"history";a:1:{i:0;a:3:{s:9:"charge_id";i:1674886;s:6:"status";s:7:"settled";s:10:"created_at";s:19:"2022-08-21 12:33:37";}}}', 
                'features' => 'O:8:"stdClass":6:{s:2:"id";s:1:"1";s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:5:"value";s:5:"19.90";s:13:"value_details";s:18:"R$ 19,90 /monthly";s:7:"adverts";s:2:"10";}', 
                'created_at' => '2022-08-21 12:33:40', 
                'updated_at' => '2022-08-21 12:35:07'
            ),
            array(
                'id' => '2', 
                'user_id' => '3', 
                'subscription_id' => '65908', 
                'plan_id' => '9337', 
                'charge_not_paid' => NULL, 
                'status' => 'active', 
                'is_paid' => '1', 
                'valid_until' => '2022-08-21 14:39:12', 
                'reason_charge' => 'Cobrança paga manualmente', 
                'history' => 'a:12:{s:15:"subscription_id";i:65908;s:5:"value";i:1990;s:6:"status";s:6:"active";s:9:"custom_id";N;s:16:"notification_url";N;s:14:"payment_method";s:14:"banking_billet";s:14:"next_execution";s:10:"2022-09-13";s:14:"next_expire_at";s:10:"2022-09-23";s:4:"plan";a:4:{s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:8:"interval";i:1;s:7:"repeats";N;}s:11:"occurrences";i:1;s:10:"created_at";s:19:"2022-08-21 13:37:47";s:7:"history";a:1:{i:0;a:3:{s:9:"charge_id";i:1674890;s:6:"status";s:7:"settled";s:10:"created_at";s:19:"2022-08-21 13:37:47";}}}', 
                'features' => 'O:8:"stdClass":6:{s:2:"id";s:1:"1";s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:5:"value";s:5:"19.90";s:13:"value_details";s:18:"R$ 19,90 /monthly";s:7:"adverts";s:2:"10";}', 
                'created_at' => '2022-08-21 13:37:50', 
                'updated_at' => '2022-08-21 13:39:12'
            ),
            array('id' => '3', 
            'user_id' => '4', 
            'subscription_id' => '65909', 
            'plan_id' => '9337', 
            'charge_not_paid' => NULL, 
            'status' => 'active', 
            'is_paid' => '1', 
            'valid_until' => '2022-08-21 14:46:54', 
            'reason_charge' => 'Cobrança paga manualmente', 
            'history' => 'a:12:{s:15:"subscription_id";i:65909;s:5:"value";i:1990;s:6:"status";s:6:"active";s:9:"custom_id";N;s:16:"notification_url";N;s:14:"payment_method";s:14:"banking_billet";s:14:"next_execution";s:10:"2022-09-20";s:14:"next_expire_at";s:10:"2022-09-30";s:4:"plan";a:4:{s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:8:"interval";i:1;s:7:"repeats";N;}s:11:"occurrences";i:1;s:10:"created_at";s:19:"2022-08-21 13:46:11";s:7:"history";a:1:{i:0;a:3:{s:9:"charge_id";i:1674893;s:6:"status";s:7:"settled";s:10:"created_at";s:19:"2022-08-21 13:46:11";}}}', 
            'features' => 'O:8:"stdClass":6:{s:2:"id";s:1:"1";s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:5:"value";s:5:"19.90";s:13:"value_details";s:18:"R$ 19,90 /monthly";s:7:"adverts";s:2:"10";}', 
            'created_at' => '2022-08-21 13:46:13', 
            'updated_at' => '2022-08-21 13:46:54'
        ),
            array(
                'id' => '4', 
                'user_id' => '5', 
                'subscription_id' => '65910', 
                'plan_id' => '9337', 
                'charge_not_paid' => NULL, 
                'status' => 'active', 
                'is_paid' => '1', 
                'valid_until' => '2022-08-21 15:01:19', 
                'reason_charge' => 'Cobrança paga manualmente', 
                'history' => 'a:12:{s:15:"subscription_id";i:65910;s:5:"value";i:1990;s:6:"status";s:6:"active";s:9:"custom_id";N;s:16:"notification_url";N;s:14:"payment_method";s:14:"banking_billet";s:14:"next_execution";s:10:"2022-09-14";s:14:"next_expire_at";s:10:"2022-09-26";s:4:"plan";a:4:{s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:8:"interval";i:1;s:7:"repeats";N;}s:11:"occurrences";i:1;s:10:"created_at";s:19:"2022-08-21 14:00:19";s:7:"history";a:1:{i:0;a:3:{s:9:"charge_id";i:1674895;s:6:"status";s:7:"settled";s:10:"created_at";s:19:"2022-08-21 14:00:19";}}}', 
                'features' => 'O:8:"stdClass":6:{s:2:"id";s:1:"1";s:7:"plan_id";i:9337;s:4:"name";s:12:"Plano Mensal";s:5:"value";s:5:"19.90";s:13:"value_details";s:18:"R$ 19,90 /monthly";s:7:"adverts";s:2:"10";}', 
                'created_at' => '2022-08-21 14:00:21',
                 'updated_at' => '2022-08-21 14:01:19'
                ),
            array(
                'id' => '5', 
                'user_id' => '6',
                 'subscription_id' => '65911', 
                 'plan_id' => '9338', 
                 'charge_not_paid' => NULL, 
                 'status' => 'active', 
                 'is_paid' => '1', 
                 'valid_until' => '2022-08-21 15:08:34', 
                 'reason_charge' => 'Cobrança paga manualmente', 
                 'history' => 'a:12:{s:15:"subscription_id";i:65911;s:5:"value";i:5500;s:6:"status";s:6:"active";s:9:"custom_id";N;s:16:"notification_url";N;s:14:"payment_method";s:14:"banking_billet";s:14:"next_execution";s:10:"2022-11-13";s:14:"next_expire_at";s:10:"2022-11-23";s:4:"plan";a:4:{s:7:"plan_id";i:9338;s:4:"name";s:16:"Plano Trimestral";s:8:"interval";i:3;s:7:"repeats";N;}s:11:"occurrences";i:1;s:10:"created_at";s:19:"2022-08-21 14:07:44";s:7:"history";a:1:{i:0;a:3:{s:9:"charge_id";i:1674896;s:6:"status";s:7:"settled";s:10:"created_at";s:19:"2022-08-21 14:07:44";}}}',
                 'features' => 'O:8:"stdClass":6:{s:2:"id";s:1:"2";s:7:"plan_id";i:9338;s:4:"name";s:16:"Plano Trimestral";s:5:"value";s:5:"55.00";s:13:"value_details";s:20:"R$ 55,00 /quarterly";s:7:"adverts";s:2:"20";}', 
                 'created_at' => '2022-08-21 14:07:46', 
                 'updated_at' => '2022-08-21 14:08:34'
            )
        );

        return $subscriptions;
    }
}
