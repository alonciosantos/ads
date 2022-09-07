<?php

namespace App\Models;

use App\Entities\Advert;
use Exception;

class AdvertModel extends MyBaseModel
{
    private $user;

    public function __construct()
    {
        parent::__construct(); // o construtor MyBaseModel


        /**
         * @todo  $this->user = service('auth')->user() ?? auth('api')->user(); // alterar estiver trabalhando com a api
         */

        $this->user = service('auth')->user(); // pega o usuario logado

    }

    protected $DBGroup          = 'default';
    protected $table            = 'adverts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\Advert::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'category_id',
        'code',
        'title',
        'description',
        'price',
        //'is_published',  esse não colocamos aqui pois queremos ter um controle maior quando o anuncio  devera ser publicado ou despublicado
        'situation',
        'zipcode',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeDataXSS',  'generateCitySlug', 'generateCode', 'setUserID']; // roda a class descrita antes de inserir
    protected $beforeUpdate   = ['escapeDataXSS',  'generateCitySlug', 'unpublished']; // roda a class descrita antes de atualizar

    protected function generateCitySlug(array $data): array
    {
        if (isset($data['data']['city'])) { //verifica a posicao name em $data

            //se houver cria um aposição slug e coloca a partir da categoria e colocar em minusculo
            $data['data']['city_slug'] = mb_url_title($data['data']['city'], lowercase: true);
        }
        return $data;
    }

    protected function generateCode(array $data): array
    {
        if (isset($data['data'])) { //verifica a posicao name em $data

            //se houver cria um aposição slug e coloca a partir da categoria e colocar em minusculo
            $data['data']['code'] = strtoupper(uniqid('ADVET_', TRUE));
        }
        return $data;
    }

    protected function setUserID(array $data): array
    {
        if (isset($data['data'])) {

            $data['data']['user_id'] = $this->user->id;
        }

        return $data;
    }

    protected function unpublished(array $data): array
    {
        //houve alteração no title ou no description
        if (isset($data['data']['title']) || isset($data['data']['description'])) {

            // sim ... houv ealteração ... entao tornamos o anuncio como não publicado(false)
            $data['data']['is_published'] = false;

            // enviar email de notificao para administrador e para o anunciante

            /**
             * @todo codigo de envio de notificação
             */
        }

        return $data;
    }

    /**
     * Recupera todos os anúncios de acordo com o usuario logado
     * 
     * @param boolean $onlyDeleted
     * @return array
     * 
     */
    public function getAllAdverts(bool $onlyDeleted = false)
    {
        $this->setSQLMode();

        $builder = $this;

        if ($onlyDeleted) {

            $builder->onlyDeleted();
        }

        $tableFields = [ // campos a enviar
            'adverts.*',
            'categories.name AS category', // apelidamos categories.name como category
            'adverts_images.image AS images', // apelido ALIAS adverts_images.image de 'images' e utilizaremos no metodo image() do Entity Advert

        ];

        $builder->select($tableFields);

        //analisamos quem esta logado
        //quem e que esta logado e o manager?
        if (!$this->user->isSuperadmin()) {

            // é o usuario anunciante ... entamos recuperamos os anuncio dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        //fazemo um join de categories e adverts_images

        $builder->join('categories', 'categories.id = adverts.category_id');

        $builder->join('adverts_images', 'adverts_images.adverts_id = adverts.id', 'LEFT'); // nem todos os anuncios terão imagens

        $builder->where('adverts.is_published = 1'); // somente anuncio publicados

        $builder->groupBy('adverts.id'); // para nao repetir registros

        $builder->orderBy('adverts.id', 'DESC');

        return $builder->findAll();
    }
    public function getAllAdvertsManager(bool $onlyDeleted = false)
    {
        $this->setSQLMode();

        $builder = $this;
        
        if ($onlyDeleted) {

            $builder->onlyDeleted();
        }
        

        $tableFields = [ // campos a enviar
            'adverts.*',
            'categories.name AS category', // apelidamos categories.name como category
            'adverts_images.image AS images', // apelido ALIAS adverts_images.image de 'images' e utilizaremos no metodo image() do Entity Advert

        ];

        $builder->select($tableFields);

        //analisamos quem esta logado
        //quem e que esta logado e o manager?
        if (!$this->user->isSuperadmin()) {

            // é o usuario anunciante ... entamos recuperamos os anuncio dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        //fazemo um join de categories e adverts_images

        $builder->join('categories', 'categories.id = adverts.category_id');

        $builder->join('adverts_images', 'adverts_images.adverts_id = adverts.id', 'LEFT'); // nem todos os anuncios terão imagens

       // $builder->where('adverts.is_published = 1'); // somente anuncio publicados

        $builder->groupBy('adverts.id'); // para nao repetir registros

        $builder->orderBy('adverts.is_published', 'ASC');

        return $builder->findAll();
    }

    public function getAllAdvertsNoPublished(bool $onlyDeleted = false)
    {
        $this->setSQLMode();

        $builder = $this;

        if ($onlyDeleted) {

            $builder->onlyDeleted();
        }

        $tableFields = [ // campos a enviar
            'adverts.*',
            'categories.name AS category', // apelidamos categories.name como category
            'adverts_images.image AS images', // apelido ALIAS adverts_images.image de 'images' e utilizaremos no metodo image() do Entity Advert

        ];

        $builder->select($tableFields);

        //analisamos quem esta logado
        //quem e que esta logado e o manager?
        if (!$this->user->isSuperadmin()) {

            // é o usuario anunciante ... entamos recuperamos os anuncio dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        //fazemo um join de categories e adverts_images

        $builder->join('categories', 'categories.id = adverts.category_id');

        $builder->join('adverts_images', 'adverts_images.adverts_id = adverts.id', 'LEFT'); // nem todos os anuncios terão imagens

        $builder->where('adverts.is_published = 0'); // somente anuncio não publicados

        $builder->groupBy('adverts.id'); // para nao repetir registros

        $builder->orderBy('adverts.id', 'DESC');

        return $builder->findAll();
    }

    /**
     * Recupera o anuncio de acordo com o id
     * @param integer $id
     * @param boolean $withDeleted
     * @return oblect|null
     */

    public function getAdvertByID(int $id, $withDeleted = false)
    { 
        //$this->setSQLMode();

        $builder = $this;

        $tableFields = [ // campos a receber
            'adverts.*',
            'users.email', // para notificar o anunciante
        ];

        $builder->select($tableFields);

        $builder->withDeleted($withDeleted);

        //analisamos quem esta logado
        //quem e que esta logado e o manager?
        if (!$this->user->isSuperadmin()) {

            // é o usuario anunciante ... entamos recuperamos os anuncio dele

            $builder->where('adverts.user_id', $this->user->id);
        }

        //fazemo um join de categories e adverts_images

        $builder->join('users', 'users.id = adverts.user_id'); // retorna somente um anuncio

        $advert = $builder->find($id); //passamos o id do anuncio . retorna ouma linha

        // Foi encontrado um anúncio?
        if (!is_null($advert)) {

            // sim ... entao podemos buscar as imagens do anuncio
            $advert->images = $this->getAdvertImages($advert->id); //criar a propriedade $advert->images, pegando o id que passamos

        }
        //retornamos o anuncio que pode ou não ter images
        return $advert; // se houver o registro, retornamos o mesmo
    }

    public function getAdvertImages(int $advertID): array
    {
        return $this->db->table('adverts_images')->where('adverts_id', $advertID)->get()->getResult();
    }

    public function trySaveAdvert(Advert $advert, bool $protect = true)
    {

        try {
            // code

            $this->db->transStart();

            $this->protect($protect)->save($advert);

            $this->db->transComplete();
        } catch (\Exception $e) {

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10041 :Error saving data');
        }
    }

    public function tryStoreAdvertImages(array $dataImages, int $advertID)
    {

        try {
            //inicia a transação com banco de dados
            $this->db->transStart();


            //armazana o caminho da imagens anuncio no banco de dados
            $this->db->table('adverts_images')->insertBatch($dataImages);

            // despublica o anuncio para evitar imagens em desacordo com a plataforma
            $this->protect(false)->set('is_published', false)->where('id', $advertID)->update();
            //desprotege e muda is_publised para false onde o id e igual $advertID e atualiza.

            // finaliza a transação do banco de dados
            $this->db->transComplete();
        } catch (\Throwable $e) {
            //throw $th;
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error saving data');
        }
    }

    public function tryDeleteAdvertImage(string $image, int $advertID)
    {
        $criteria = [
            'adverts_id' => $advertID,
            'image' => $image
        ];


        return $this->db->table('adverts_images')->where($criteria)->delete();
    }

    public function tryArchiveAdvert(int $advertID)
    {

        try {
            $this->db->transStart();


        //analisamos quem esta logado
        //quem e que esta logado e o manager?
        if (!$this->user->isSuperadmin()) {

             // é o usuario anuncioante.... , entao arquivamos apenas o anuncio dele
             $this->where('user_id', $this->user->id)->delete($advertID);

        }else{
            // é o manager arquivando
            $this->delete($advertID);
        }

        
           
            

            $this->db->transComplete();
        } catch (\Exception $e) {
            //throw $th;

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error archiving data');
        }
    }

    public function tryDeleteAdvert(int $advertID)
    {
        try {

            $this->db->transStart();

            if (!$this->user->isSuperadmin()) {

                $this->where('user_id', $this->user->id)->delete($advertID, true);
            }else{
                // é o manager arquivando
            $this->delete($advertID,true);
            }

            $this->db->transComplete();
        } catch (\Exception $e) {
            //throw $th;

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error deleting data');
        }
    }

    public function getAllAdvertsPaginated(int $perPage = 10, array $criteria = [])
    {
        $this->setSQLMode();

        $builder = $this;

        $tableFields = [

            'adverts.*',
            'categories.name AS category',
            'categories.slug AS category_slug',
            'adverts_images.image AS images', // para utilizarmos no metodo image do entity advert

        ];

        $builder->select($tableFields);
        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->join('adverts_images', 'adverts_images.adverts_id = adverts.id');

        if (!empty($criteria)) {
            $builder->where($criteria);
        }

        $builder->where('adverts.is_published',true);
        $builder->orderBy('adverts.id','DESC');
        $builder->groupBy('adverts.id');

        $adverts = $builder->paginate($perPage);

        return $adverts;
    }

    public function getAdvertByCode(string $code, bool $offTheLoggedInUser = false) // crian na classe de serviço
    {
        $tableFields =[
            'adverts.*',
            'users.name',
            'users.email', /// usaremos para a parte de perguntas
            'users.username',
            'users.phone',
            'users.display_phone',
            'users.created_at AS user_since',
            'categories.name AS category',
            'categories.slug AS category_slug', // usaremos para filtrar os anuncios por categorias

        ];

        $builder = $this;
        $builder->select($tableFields);
        $builder->join('users', 'users.id = adverts.user_id');
        $builder->join('categories', 'categories.id = adverts.category_id');
        $builder->where('adverts.is_published',true);
        $builder->where('adverts.code',$code);


        if($offTheLoggedInUser){

            $builder->where('adverts.user_id', $this->user->id);

        }

        $advert=$builder->first();

        if(!is_null($advert)){
            // recupero as imagens do mesmo
            $advert->images = $this->getAdvertImages($advert->id);
        }

        if(!is_null($advert)){
            // recupero as perguntas e respostas do mesmo

           $advert->questions = $this->getAdvertQuestions($advert->id);
        }

        return $advert;

    }

    public function getCitiesFromPublishedAdverts(int $limit = 5, string $categorySlug = null):array{

        $this->setSQLMode();

        $tableFields = [
            'adverts.*',
            'categories.name AS category', // para debug
            'COUNT(adverts.id) AS total_adverts'
        ];

        //recupero apenas os adverts_id da tabela de images
        $advertsIDS = array_column($this->db->table('adverts_images')->select('adverts_id')->get()->getResultArray(),'adverts_id');
        
        $builder = $this;

        $builder->select($tableFields);
        //$builder->asArray(); //para debug
        
        $builder->join('categories','categories.id = adverts.category_id');
        $builder->where('adverts.is_published', true);
        $builder->where('categories.slug',$categorySlug);
        $builder->whereIn('adverts.id',$advertsIDS); // apenas em anuncios que possui imagens
        $builder->groupBy('adverts.city');
        $builder->orderBy('total_adverts','DESC');

        return $builder->findAll($limit);
    
}

//verifica quantos anuncio o usuario logado ja tem cadastrado.
public function countAllUserAdverts(int $userID, bool $withDeleted = true, array $criteria = []):int
{
    $builder = $this;

    if(!empty($criteria)){

        $builder->where($criteria);

    }

    $builder->where('adverts.user_id',$userID);

    $builder->withDeleted($withDeleted);

    return $builder->countAllResults();
}

// auto-complete pesquisa por auto complite

public function getAllAdvertByTerm(string $term = null):array
{

    $this->setSQLMode();
    $builder = $this;

    $tableFields=[

        'adverts.id',
        'adverts.code',
        'adverts.title',
        'adverts_images.image AS images',
    ];

        $builder->select($tableFields);
        $builder->join('adverts_images', 'adverts_images.adverts_id=adverts.id','LEFT'); // nem todos os anuncio não tem imagens
        $builder->groupBy('adverts.id');
        $builder->orderBy('adverts.id','DESC');
        $builder->where('is_published',true); // apenas anuncios publicados
        $builder->like('title',$term, 'both'); //both %busca%

        return  $builder->findAll();

}

//*************************************** PERGUNTAS E RESPOSTAS   ************************************

// pegar anuncios e resposta que o anuncio possui

public function getAdvertQuestions(int $advertID):array
{

    $builder = $this->db->table('adverts_questions');
    $builder->where('advert_id',$advertID);
    $builder->orderBy('id','DESC');
    return  $builder->get()->getResult();


}


public function tryInsertAdvertQuestion(int $advertID, string $question)
{
    try {

        $this->db->transStart();

        $data = [
            'advert_id'         =>$advertID,
            'user_question_id'  =>$this->user->id, //ver no __contruct()
            'question'          =>esc($question),
            'created_at'         =>date('Y-m-d H:i:s'),
        ];

         $this->db->table('adverts_questions')->insert($data);

        $this->db->transComplete();
    } catch (\Exception $e) {
        //throw $th;

        log_message('error', '[ERROR] {exception}', ['exception' => $e]);

        die('Erro ao realizar pergunta');
    }

}

public function answerAdvertQuestion(int $questionID, int $advertID, string $answer)
{
    try {

        $this->db->transStart();
        //aqui indicamos os criterios para não responder qualquer pergunta, o id tem que ser igual $questionID 
        //e o advert_id tem que ser igual $advertID

        $criteria = [
            'id'            =>$questionID,
            'advert_id'     =>$advertID
        ];
        //recebe a respostas
        $data = [
            
            'answer'         =>esc($answer),
            'updated_at'     =>date('Y-m-d H:i:s'),
        ];

         $this->db->table('adverts_questions')->where($criteria)->update($data);

        $this->db->transComplete();
    } catch (\Exception $e) {
        //throw $th;

        log_message('error', '[ERROR] {exception}', ['exception' => $e]);

        die('Erro ao respoder a pergunta');
    }

}

}
