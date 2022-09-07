<?php

namespace Config;

use App\Entities\Advert;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validations\Customized; //nossas validações

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        Customized::class, // nossas validações
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    //Categories
    public $category = [

        'name'  => 'required|min_length[3]|max_length[90]|is_unique[categories.name,id,{id}]',
    ];

    public $category_errors = [

        'name'  => [
            'required'      => 'Categories.name.required', // o lang não pode ser colocado aqui... dara erro de sitaxe
            'min_length'    => 'Categories.name.min_length',
            'max_length'    => 'Categories.name.max_length',
            'is_unique'     => 'Categories.name.is_unique',
        ],
    ];

    //Plans

    public $plan = [

        'name'               => 'required|min_length[3]|max_length[90]|is_unique[plans.name,id,{id}]',
        'recorrence'         => 'required|in_list[monthly,quarterly,semester,yearly]',
        'value'              => 'required',
        'description'        => 'required',
    ];

    public $plan_errors = [

        'recorrence'  => [

            'in_list'    => 'Plans.recorrence.in_list',


        ],
    ];



    //Adverts
    public $advert = [

        'title'         => 'required|min_length[5]|max_length[120]|is_unique[adverts.title,id,{id}]',
        'situation'     => 'required|in_list[new,used]',
        'category_id'      => 'required|is_not_unique[categories.id,id,{category_id}]',
        'price'         => 'required',
        'description'   => 'required|max_length[5000]',
        'zipcode'       => 'required|exact_length[9]',
        'street'        => 'required|max_length[130]',
        'number'        => 'required',
        'neighborhood'  => 'required|max_length[130]',
        'city'          => 'required|max_length[130]',
        'state'         => 'required|exact_length[2]',


    ];

    public $advert_errors = [

        'title'  => [
            'is_unique'     => 'adverts.title.is_unique',
            // criar os demais error e tarduções
        ],
    ];

    public $advert_images = [

        'images' => 'uploaded[images]'
            . '|is_image[images]'
            . '|mime_in[images,image/jpg,image/jpeg,image/png,image/webp]'
            . '|max_size[images,4096]'
            . '|max_dims[images,1500,1500]',
    ];

    public $advert_images_errors = [];

    // User validation para pagamento na gerencianet

    public $user_profile = [

        'name'         => 'required|min_length[2]|max_length[30]',
        'last_name'    => 'required|min_length[2]|max_length[50]',
        'email'         => 'required|valid_email|min_length[8]|max_length[240]|is_unique[users.email,id,{id}]',
        'cpf'          => 'required|validate_cpf|is_unique[users.cpf,id,{id}]', // criar classe de validação de cpf customizada
        'phone'         => 'required|validate_phone|exact_length[15]|is_unique[users.phone,id,{id}]', // criar metodo de validar phone
        'birth'         => 'required',
    ];

    public $user_profile_errors = [];




    // Access Update - compara as senhas se são iguais


    public $access_update = [

        'password'              => 'required|min_length[8]',
        'password_confirmation' => 'matches[password]',

    ];

    public $access_update_errors = [];

    //Gerencianet
    public $gerencianet_billet = [

        'payment_method'     => 'required|in_list[credit,billet]',
        'expire_at'          => 'required|valid_date[Y-m-d]',
    ];

    public $gerencianet_credit = [

        'payment_method'            => 'required|in_list[credit,billet]',
        'card_number'               => 'required',
        'card_expiration_date'      => 'required',
        'card_cvv'                  => 'required',
        'card_brand'                => 'required|in_list[visa,elo,mastercard,amex,diners,hipercard]',
        'payment_token'             => 'required|string',
        'zipcode'                   => 'required',
        'street'                    => 'required',
        'city'                      => 'required',
        'neighborhood'              => 'required',
        'state'                     => 'required',
        

    ];

    public $gerencianet_credit_errors = [

        'payment_method'  => [
            'in_list'     => 'Por favor escolha Credito ou Boleto Bancario',
            // criar os demais error e tarduções
        ],
    ];

    public $gerencianet_billet_errors = [

        'payment_method'  => [
            'in_list'     => 'Por favor escolha Credito ou Boleto Bancario',

            // criar os demais error e tarduções
        ],
    ];
}
