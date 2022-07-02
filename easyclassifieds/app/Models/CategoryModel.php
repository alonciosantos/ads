<?php

namespace App\Models;

class CategoryModel extends MyBaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = Category::class;
   //protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // default false marca como deletado
    protected $protectFields    = true;
    protected $allowedFields    = [
        'parent_id',
        'name',
        'slug',
    ];

    // Dates
    protected $useTimestamps = true; // ativa os campos abaixo quando for atualizados
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

   
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeDataXSS']; // roda a class descrita antes de inserir
    protected $beforeUpdate   = ['escapeDataXSS']; // roda a class descrita antes de atualizar
    
}
