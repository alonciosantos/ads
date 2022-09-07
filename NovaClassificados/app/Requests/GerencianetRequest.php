<?php

namespace App\Requests;

class GerencianetRequest extends MyBaseRequest
{
    public function validateBeforeSave(string $paymentMethod, bool $repondWithRedirect= false)
    {
        $this->validation($this->SetRuleGroup($paymentMethod),$repondWithRedirect);
    }

    private function SetRuleGroup(string $paymentMethod)
    {
        return $paymentMethod == 'billet' ? 'gerencianet_billet' : 'gerencianet_credit';
    }
}