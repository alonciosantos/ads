<?php

namespace App\Requests;

class CategoryRequest extends MyBaseRequest
{
    public function validateBeforeSave(string $ruleGroup, bool $repondWithRedirect= false)
    {
    $this->validation($ruleGroup,$repondWithRedirect);
    }
}