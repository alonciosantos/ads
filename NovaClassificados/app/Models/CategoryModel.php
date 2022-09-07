<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends MyBaseModel
{
    protected $DBGroup            = 'default';
    protected $table              = 'categories';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $insertID           = 0;
    protected $returnType         = \App\Entities\Category::class;
    protected $useSoftDeletes     = true;
    protected $protectFields      = true;
    protected $allowedFields      = [
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
    protected $beforeInsert   = ['escapeDataXSS',  'generateSlug']; // roda a class descrita antes de inserir
    protected $beforeUpdate   = ['escapeDataXSS',  'generateSlug']; // roda a class descrita antes de atualizar

    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['name'])) { //verifica a posicao name em $data

            //se houver cria um aposição slug e coloca a partir da categoria e colocar em minusculo
            $data['data']['slug'] = mb_url_title($data['data']['name'], lowercase: true);
        }
        return $data;
    }

    public function getParentCategories(int $exceptCategoryID = null): array
    {

        $builder = $this; //construtor do metodo Builder

        if ($exceptCategoryID) {

            $builder->where('id !=', $exceptCategoryID);
        }

        $builder->orderBy('name', 'ASC');

        $builder->asArray();

        return $builder->findAll();
    }


    /**
     * Metodo que recupera que fazem partes de anuncios publicados
     * 
     * @param integer $limit
     * @return array
     */
    public function getCategoriesFromPublishedAdverts(int $limit = 5): array
    {
        $this->setSQLMode();

        $tableFields = [
            'categories.*',
            'COUNT(adverts.id) AS total_adverts'
        ];

        //recupero apenas os adverts_id da tabela de images
        $advertsIDS = array_column($this->db->table('adverts_images')->select('adverts_id')->get()->getResultArray(),'adverts_id');
        
        $builder = $this;

        $builder->select($tableFields);
        $builder->asObject();
        //$builder->asArray();
        $builder->join('adverts','adverts.category_id = categories.id');
        $builder->where('adverts.is_published', true);

        // quero garantir que apenas anuncios com imagens seja contabilizados.
        if(!empty($advertsIDS)){

           $builder->whereIn('adverts.id',$advertsIDS);

           $builder->groupBy('categories.name');
           $builder->orderBy('total_adverts','DESC');

           return $builder->findAll($limit);

        }
    }
}
