<?php

namespace App\Requests;

class PlanRequest extends MyBaseRequest
{
    public function validateBeforeSave(string $ruleGroup, bool $repondWithRedirect= false)
    {
    $this->validation($ruleGroup,$repondWithRedirect);
    }
}