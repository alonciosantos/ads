<?php

namespace App\Services;

use App\Entities\Plan;
use App\Models\PlanModel;
use CodeIgniter\Config\Factories;

class PlanService
{
    private $planModel;
    private $gerencianetService;

    public function __construct()
    {
        $this->planModel= Factories::models(PlanModel::class);
        $this->gerencianetService = Factories::class(gerencianetService::class);
    }
           

    public function getAllPlans():  array
    {
        //$plans = $this->planModel->findAll();
        $plans = $this->planModel->findAll();

        
        $data = [];
        

        foreach ($plans as $plan) {

            $btnEdit = form_button(
                [
                    'data-id' => $plan->id,
                    'id'      => 'updatePlanBtn', // ID do htm element
                    'class'   => 'btn btn-primary btn-sm'
                ],
                lang('App.btn_edit')
            );

            $btnArchive = form_button(
                [
                    'data-id' => $plan->id,
                    'id'      => 'archivePlanBtn', // ID do htm element
                    'class'   => 'btn btn-info btn-sm'
                ],
                lang('App.btn_archive')
            );

            $data[] = [
                'code'              => $plan->plan_id,
                'name'              => $plan->name,
                'is_highlighted'    => $plan->isHighlighted(),
                'details'           => $plan->details(),
                'action'            => $btnEdit . '  ' . $btnArchive,
            ];

            
        }

        return $data;
    }

    public function getAllArchived():  array
    {
        //$plans = $this->planModel->findAll();
        $plans = $this->planModel->onlyDeleted()->findAll();

        
        $data = [];
        

        foreach ($plans as $plan) {

            $btnRecover = form_button(
                [
                    'data-id' => $plan->id,
                    'id'      => 'recoverPlanBtn', // ID do htm element
                    'class'   => 'btn btn-primary btn-sm'
                ],
                lang('App.btn_recovery')
            );

            $btnDelete = form_button(
                [
                    'data-id' => $plan->id,
                    'id'      => 'deletePlanBtn', // ID do htm element
                    'class'   => 'btn btn-danger btn-sm'
                ],
                lang('App.btn_del')
            );

            $data[] = [
                'code'              => $plan->plan_id,
                'name'              => $plan->name,
                'is_highlighted'    => $plan->isHighlighted(),
                'details'           => $plan->details(),
                'action'            => $btnRecover . '  ' . $btnDelete,
            ];

            
        }

        return $data;
    }
    
    public function getRecorrences(string $recorrence = null):string
    {
        $options = [];
        $selected = [];

        $options =[
            ''                              => lang('Plans.label_recorrence'), // option vazio
            Plan::OPTION_MONTHLY            => lang('Plans.text_monthly'),
            Plan::OPTION_QUARTERLY          => lang('Plans.text_quarterly'),
            Plan::OPTION_SEMESTER           => lang('Plans.text_semester'),
            Plan::OPTION_YEARLY             => lang('Plans.text_yearly'),
        ];

        // estou criando um plano?

       

        if(is_null($recorrence))
        {
            return form_dropdown('recorrence',$options,$selected,[ 'class' => 'form-control']);
        }

        //estamos efetivamente editando um plano..

        // fazemos a comparação da recorrencia do id recebido com os Plan:OPTIONS, e  armazena no selected
        // a opção igual a do recorrence pelo no id
        $selected[] = match($recorrence){
            Plan::OPTION_MONTHLY            => Plan::OPTION_MONTHLY,
            Plan::OPTION_QUARTERLY          => Plan::OPTION_QUARTERLY ,
            Plan::OPTION_SEMESTER           => Plan::OPTION_SEMESTER,
            Plan::OPTION_YEARLY             => Plan::OPTION_YEARLY,
            default                         => throw new \InvalidArgumentException("Unsupported recorrence {$recorrence}"),
                };

                
        return form_dropdown('recorrence',$options,$selected,[ 'class' => 'form-control']);
    
        
    }

    public function trySavePlan(Plan $plan, bool $protect =true)
    {

        /**
         * @todo gerenciar a criação /atualização na gerencianet
         */
        try{
                // criamos o plano na gerencianet
            $this->createOrUpdatePlanOnGerencianet($plan); // referencia na linha 59 GerencianetService 

            if($plan->hasChanged()){
                // e aqui salvamos no nosso banco de dados
                $this->planModel->protect($protect)->save($plan);
               

            }

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }
    }
  
    public function getPlanByID(int $id, bool $withDeleted = false)
    {
        $plan = $this->planModel->withDeleted($withDeleted)->find($id);


        if(is_null($plan)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Plan not found!');
        }
        return $plan;
    }

    public function tryArchivePlan(int $id)
    {
        try{

            $plan=$this->getPlanByID($id);

            $this->planModel->delete($plan->id); // deletando o plano atraves do id

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }

    public function tryRecoverPlan(int $id)
    {
        try{

            $plan = $this->getPlanByID($id, withDeleted: true); //paga os planos marcadas como deletada

            $plan->recover(); // recupera o plano 

           // $this->trySavePlan($plan, protect: false);
            $this->planModel->protect(false)->save($plan);

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }

    public function tryDeletePlan(int $id)
    {
        try{

            $plan =$this->getPlanByID($id, withDeleted: true); //paga o plano marcado como deletado

            $this->gerencianetService->deletePlan($plan->plan_id); // deleta o plano na gerencianet

            $this->planModel->delete($plan->id, purge:true); //deleta permanente o plano

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }

    public function getPlansToSell()
    {

        return  $this->planModel->findAll();

    }

    public function getChoosenPlan(int $planID)
    {

        return $this->getPlanByID($planID);

        
    }
    

    private function createOrUpdatePlanOnGerencianet(Plan $plan)
    {
        //estamos criandoum plano?
        if(empty($plan->id)){

            // sim .. criando o plano na gerencianet

            return $this->gerencianetService->createPlan($plan);
        }else{

            // estamos atualizando...
            // contudo precisamos verificar se o nome do plano foi alterado
            // a Gerencianet permite atualizar somente o plano

            if($plan->hasChanged('name')){

                return $this->gerencianetService->updatePlan($plan);
            }

        }

    }
}