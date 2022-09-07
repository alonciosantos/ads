<?php

namespace App\Models;

use App\Entities\Subscription;


class SubscriptionModel extends MyBaseModel
{
    private $user;
    public function __construct()
    {

        parent::__construct(); // construtor que é pai do MyBaseModel
/**
 * @todo  $this->user = service('auth')->user(); alterar quando estivermos com api
 */

        $this->user = service('auth')->user();
    }


    protected $DBGroup          = 'default';
    protected $table            = 'subscriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\Subscription::class;
    protected $useSoftDeletes   = false; // não usamos o softdelete nesse modelo
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'subscription_id',
        'plan_id',
        'charge_not_paid',
        'status',
        'is_paid',
        'history',
        'features',
        'valid_until',
        'reason_charge',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
  


    /**
     * Recupera a assinatura do usuario/anuciante logado
     * 
     * @return object|null
     */
    public function getUserSubscription()
    {
        return $this->where('user_id', $this->user->id)->first();

        //dd($this->where('user_id', $this->user->id)->first());
    }

    public function saveSubscription(Subscription $subscription)
    {
        try {
            $this->db->transStart();

            $this->save($subscription);

            $this->db->transComplete();

            

        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            
            die('Não foi possivel salvar a assinatura');

        }
    }

    /**
     * Metodo que exclui do modelo a assinatura do usuario logado de acordo com o parametro informado
     
     * @param integer $subscriptionID
     * @return boolean
     */

    public function destroyUserSubscription(int $subscriptionID)
    {
        try {
            $this->db->transStart();

            $builder = $this;
            
            $builder->where('user_id', $this->user->id);
            $builder->where('subscription_id', $subscriptionID);
            $builder->delete();
            
            $this->db->transComplete();

            return true;

        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            
            die('Não foi possivel excluir a assinatura');

        }
    }
    
}
