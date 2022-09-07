<?php

namespace App\Models;
use CodeIgniter\Model;
//use App\Entities\Plan;

class PlanModel extends MyBaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'plans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\Plan::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id' ,
        'plan_id',
        'name' ,
        'recorrence' ,
        'adverts',
        'description',
        'value',
        'is_highlighted',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeDataXSS'];
    protected $beforeUpdate   = ['escapeDataXSS'];
    
}
