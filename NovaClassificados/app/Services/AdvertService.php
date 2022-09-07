<?php

namespace App\Services;

use App\Entities\Advert;
use App\Models\AdvertModel;
use CodeIgniter\Config\Factories;
use App\Entities\User;
use CodeIgniter\Events\Events;  // para disparar eventos de notificações
use App\Services\UserService;


class AdvertService
{
    private $user;
    private $advertModel;

    public const SITUATION_NEW = 'new';
    public const SITUATION_USED = 'used';


    public function __construct()
    {
        /**
         * @todo alterar para auth('api')->user(); ... quando estivermos trabalhando com api
         */


        $this->user = Factories::class(User::class);
        $this->advertModel = Factories::models(AdvertModel::class);
        $this->user = service('auth')->user();
    }

    public function getAllAdverts(
        bool $showBtnArvhive = true,
        bool $showBtnViewAdvert = true,
        bool $showBtnQuestions = true,
        string $classBtnActions = 'btn btn-primary btn-sm',
        //string $classBadge='badge badge-primary',
        string $sizeImage = 'small',
       ): array {

        // rotas para images coso seja superadmin ou manager
        $baseRouteToEditImages = $this->user->isSuperadmin() ? 'adverts.manager.edit.images' : 'adverts.my.edit.images';

        $baseRouteToQuestions = $this->user->isSuperadmin() ? 'adverts.manager.edit.questions' : 'adverts.my.edit.questions';

        $adverts = $this->advertModel->getAllAdverts();

        $data = [];

        foreach ($adverts as $advert) {
            // e para exibir o botao

            if ($showBtnArvhive) {

                //  sim
                $btnArchive = form_button(
                    [
                        'data-id' => $advert->id,
                        'id'      => 'btnArchiveAdvert', // ID do htm element
                        'class'   => 'dropdown-item'
                    ],
                    lang('App.btn_archive')
                );
            }




            $btnEdit = form_button(
                [
                    'data-id' => $advert->id,
                    'id'      => 'btnEditAdvert', // ID do htm element
                    'class'   => 'dropdown-item'
                ],
                lang('App.btn_edit')
            );

            $finalRouteToEditImages = route_to($baseRouteToEditImages, $advert->id);

            $btnEditImages = form_button(
                [
                    'class'   => 'dropdown-item',
                    'onClick' => "location.href='{$finalRouteToEditImages}'",
                ],
                lang('Adverts.btn_edit_images')
            );

            // o botao e para se exibido e o anuncio esta publicado
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $routeToViewAdvert = route_to('adverts.detail', $advert->code); // passamos o codigo do anuncio, na rota

                $btnViewAdvert = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick'    => "window.open('{$routeToViewAdvert}', '_blank')",
                    ],
                    lang('Adverts.btn_view_advert')
                );
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $finalRouteToEditQuestions = route_to($baseRouteToQuestions, $advert->code);

                $btnViewQuestions = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick' => "location.href='{$finalRouteToEditQuestions}'",
                    ],
                    lang('Adverts.btn_view_questions')
                );
            }

            // comecamos a monta o botao dropdown
            $btnActions = '<div class="dropdown dropup">';  //abertura da div do dropdown

            $attrBtnActions = [
                'type'              => 'button',
                'id'                => 'actions',
                'class'             => "dropdown-toggle {$classBtnActions}",
                'data-bs-toggle'    => "dropdown", // para BS5
                'data-toggle'       => "dropdown", // para BS4
                'aria-haspopup'     => "true",
                'aria-expanded'     => "false",
            ];

            $btnActions .= form_button($attrBtnActions, lang('App.btn_actions'));

            $btnActions .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';  //abertura da div do dropdown menu

            //criamos as opções de botoes (ações)
            $btnActions .= $btnEdit;
            $btnActions .= $btnEditImages;

            // aqui vamos colocar mais botoes

            // o botao e para se exibido e o anuncio esta publicado?
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewAdvert;
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewQuestions;
            }

            if ($showBtnArvhive) {
                //  sim
                $btnActions .= $btnArchive;
            }

            $btnActions .= '</div>';  //fechamento da div do dropdown menu

            $btnActions .= '</div>';  //fechamento da div do dropdown

            

            $data[] = [
                'image'           => $advert->image(classImage: 'card-img-top img-custom', sizeImage: $sizeImage), // ,sizeimage: $sizeImage metodos de redenrizaçãoda imagens em Entities/Advert.php :59 abaixo
                'title'           => $advert->title,
                'code'            => $advert->code,
                'category'        => $advert->category,
                'is_published'    => $advert->isPublished(),
                'address'         => $advert->address(),

                'action'          => $btnActions,
            ];
        }

        return $data;
    }


    public function getAllAdvertsManager(
        bool $showBtnArvhive = true,
        bool $showBtnViewAdvert = true,
        bool $showBtnQuestions = true,
        string $classBtnActions = 'btn btn-primary btn-sm',
        string $sizeImage = 'small',
       ): array {

        // rotas para images coso seja superadmin ou manager
        $baseRouteToEditImages = $this->user->isSuperadmin() ? 'adverts.manager.edit.images' : 'adverts.my.edit.images';

        $baseRouteToQuestions = $this->user->isSuperadmin() ? 'adverts.manager.edit.questions' : 'adverts.my.edit.questions';

        $adverts = $this->advertModel->getAllAdvertsManager();

        $data = [];

        foreach ($adverts as $advert) {
            // e para exibir o botao

            if ($showBtnArvhive) {

                //  sim
                $btnArchive = form_button(
                    [
                        'data-id' => $advert->id,
                        'id'      => 'btnArchiveAdvert', // ID do htm element
                        'class'   => 'dropdown-item'
                    ],
                    lang('App.btn_archive')
                );
            }




            $btnEdit = form_button(
                [
                    'data-id' => $advert->id,
                    'id'      => 'btnEditAdvert', // ID do htm element
                    'class'   => 'dropdown-item'
                ],
                lang('App.btn_edit')
            );

            $finalRouteToEditImages = route_to($baseRouteToEditImages, $advert->id);

            $btnEditImages = form_button(
                [
                    'class'   => 'dropdown-item',
                    'onClick' => "location.href='{$finalRouteToEditImages}'",
                ],
                lang('Adverts.btn_edit_images')
            );

            // o botao e para se exibido e o anuncio esta publicado
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $routeToViewAdvert = route_to('adverts.detail', $advert->code); // passamos o codigo do anuncio, na rota

                $btnViewAdvert = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick'    => "window.open('{$routeToViewAdvert}', '_blank')",
                    ],
                    lang('Adverts.btn_view_advert')
                );
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $finalRouteToEditQuestions = route_to($baseRouteToQuestions, $advert->code);

                $btnViewQuestions = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick' => "location.href='{$finalRouteToEditQuestions}'",
                    ],
                    lang('Adverts.btn_view_questions')
                );
            }

            // comecamos a monta o botao dropdown
            $btnActions = '<div class="dropdown dropup">';  //abertura da div do dropdown

            $attrBtnActions = [
                'type'              => 'button',
                'id'                => 'actions',
                'class'             => "dropdown-toggle {$classBtnActions}",
                'data-bs-toggle'    => "dropdown", // para BS5
                'data-toggle'       => "dropdown", // para BS4
                'aria-haspopup'     => "true",
                'aria-expanded'     => "false",
            ];

            $btnActions .= form_button($attrBtnActions, lang('App.btn_actions'));

            $btnActions .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';  //abertura da div do dropdown menu

            //criamos as opções de botoes (ações)
            $btnActions .= $btnEdit;
            $btnActions .= $btnEditImages;

            // aqui vamos colocar mais botoes

            // o botao e para se exibido e o anuncio esta publicado?
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewAdvert;
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewQuestions;
            }

            if ($showBtnArvhive) {
                //  sim
                $btnActions .= $btnArchive;
            }

            $btnActions .= '</div>';  //fechamento da div do dropdown menu

            $btnActions .= '</div>';  //fechamento da div do dropdown

            

            $data[] = [
                'image'           => $advert->image(classImage: 'card-img-top img-custom', sizeImage: $sizeImage), // ,sizeimage: $sizeImage metodos de redenrizaçãoda imagens em Entities/Advert.php :59 abaixo
                'title'           => $advert->title,
                'code'            => $advert->code,
                'category'        => $advert->category,
                'is_published'    => $advert->isPublished(),
                'address'         => $advert->address(),

                'action'          => $btnActions,
            ];
        }

        return $data;
    }

    public function getAllAdvertsNoPublished(
        bool $showBtnArvhive = true,
        bool $showBtnViewAdvert = true,
        bool $showBtnQuestions = true,
        string $classBtnActions = 'btn btn-primary btn-sm',
        string $sizeImage = 'small',
        ): array {

        // rotas para images coso seja superadmin ou manager
        $baseRouteToEditImages = $this->user->isSuperadmin() ? 'adverts.manager.edit.images' : 'adverts.my.edit.images';

        $baseRouteToQuestions = $this->user->isSuperadmin() ? 'adverts.manager.edit.questions' : 'adverts.my.edit.questions';

        $adverts = $this->advertModel->getAllAdvertsNoPublished();

        $data = [];

        foreach ($adverts as $advert) {
            // e para exibir o botao

            if ($showBtnArvhive) {

                //  sim
                $btnArchive = form_button(
                    [
                        'data-id' => $advert->id,
                        'id'      => 'btnArchiveAdvert', // ID do htm element
                        'class'   => 'dropdown-item'
                    ],
                    lang('App.btn_archive')
                );
            }




            $btnEdit = form_button(
                [
                    'data-id' => $advert->id,
                    'id'      => 'btnEditAdvert', // ID do htm element
                    'class'   => 'dropdown-item'
                ],
                lang('App.btn_edit')
            );

            $finalRouteToEditImages = route_to($baseRouteToEditImages, $advert->id);

            $btnEditImages = form_button(
                [
                    'class'   => 'dropdown-item',
                    'onClick' => "location.href='{$finalRouteToEditImages}'",
                ],
                lang('Adverts.btn_edit_images')
            );

            // o botao e para se exibido e o anuncio esta publicado
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $routeToViewAdvert = route_to('adverts.details', $advert->code); // passamos o codigo do anuncio, na rota

                $btnViewAdvert = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick'    => "window.open('{$routeToViewAdvert}', '_blank')",
                    ],
                    lang('Adverts.btn_view_advert')
                );
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)

                $finalRouteToEditQuestions = route_to($baseRouteToQuestions, $advert->code);

                $btnViewQuestions = form_button(
                    [
                        'class'      => 'dropdown-item',
                        'onClick' => "location.href='{$finalRouteToEditQuestions}'",
                    ],
                    lang('Adverts.btn_view_questions')
                );
            }

            // comecamos a monta o botao dropdown
            $btnActions = '<div class="dropdown dropup">';  //abertura da div do dropdown

            $attrBtnActions = [
                'type'              => 'button',
                'id'                => 'actions',
                'class'             => "dropdown-toggle {$classBtnActions}",
                'data-bs-toggle'    => "dropdown", // para BS5
                'data-toggle'       => "dropdown", // para BS4
                'aria-haspopup'     => "true",
                'aria-expanded'     => "false",
            ];

            $btnActions .= form_button($attrBtnActions, lang('App.btn_actions'));

            $btnActions .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';  //abertura da div do dropdown menu

            //criamos as opções de botoes (ações)
            $btnActions .= $btnEdit;
            $btnActions .= $btnEditImages;

            // aqui vamos colocar mais botoes

            // o botao e para se exibido e o anuncio esta publicado?
            if ($showBtnViewAdvert && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewAdvert;
            }

            // o botao e para se exibido questions
            if ($showBtnQuestions && $advert->is_published) {

                //sim ... podemos montar o botao (ação)
                $btnActions .= $btnViewQuestions;
            }

            if ($showBtnArvhive) {
                //  sim
                $btnActions .= $btnArchive;
            }

            $btnActions .= '</div>';  //fechamento da div do dropdown menu

            $btnActions .= '</div>';  //fechamento da div do dropdown


            $data[] = [
                'image'           => $advert->image(classImage: 'card-img-top img-custom', sizeImage: $sizeImage), // ,sizeimage: $sizeImage metodos de redenrizaçãoda imagens em Entities/Advert.php :59 abaixo
                'title'           => $advert->title,
                'code'            => $advert->code,
                'category'        => $advert->category,
                'is_published'    => $advert->isPublished(),
                'address'         => $advert->address(),

                'action'          => $btnActions,
            ];
        }

        return $data;
    }

    public function getArchivedAdverts(
        bool $showBtnRecover = true,
        string $classBtnRecover = '',
        string $classBtnDelete = '',
        string $classBtnActions = 'btn btn-primary btn-sm',

        ): array {


        $adverts = $this->advertModel->getAllAdverts(onlyDeleted: true);

        $data = [];

        $btnRecover = '';

        foreach ($adverts as $advert) {

            //  É para exibir o botão?
            if ($showBtnRecover) {


                $btnRecover = form_button(
                    [
                        'data-id' => $advert->id,
                        'id'      => 'btnRecoverAdvert', // ID do htm element
                        'class'   => 'dropdown-item'
                    ],
                    lang('App.btn_recovery')
                );
            }

            $btnDelete = form_button(
                [
                    'data-id' => $advert->id,
                    'id'      => 'btnDeleteAdvert', // ID do htm element
                    'class'   => 'dropdown-item'
                ],
                lang('App.btn_del')
            );



            // comecamos a monta o botao dropdown
            $btnActions = '<div class="dropdown dropup">';  //abertura da div do dropdown

            $attrBtnActions = [
                'type'              => 'button',
                'id'                => 'actions',
                'class'             => "dropdown-toggle {$classBtnActions}",
                'data-bs-toggle'    => "dropdown", // para BS5
                'data-toggle'       => "dropdown", // para BS4
                'aria-haspopup'     => "true",
                'aria-expanded'     => "false",
            ];

            $btnActions .= form_button($attrBtnActions, lang('App.btn_actions'));

            $btnActions .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';  //abertura da div do dropdown menu

            //criamos as opções de botoes (ações)
            $btnActions .= $btnRecover;
            $btnActions .= $btnDelete;


            $btnActions .= '</div>';  //fechamento da div do dropdown menu

            $btnActions .= '</div>';  //fechamento da div do dropdown


            $data[] = [

                'title'           => $advert->title,
                'code'            => $advert->code,
                'action'          => $btnActions,
            ];
        }

        return $data;
    }

    public function getAdvertByID(int $id, $withDeleted = false)
    {

        $advert = $this->advertModel->getAdvertByID($id, $withDeleted);

        if (is_null($advert)) {

            throw  \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Advert not Found');
        }
        return $advert;
    }

    public function getDropdownSituations(string $advertSituation = null)
    {
        $options = [];
        $selected = [];

        $options = [

            ''                           => lang('Adverts.label_situation'),
            self::SITUATION_NEW          => lang('Adverts.text_new'),
            self::SITUATION_USED         => lang('Adverts.text_used'),
        ];

        // estamos criando ou editado um anuncio?
        if (is_null($advertSituation)) {

            //estamos criando


            return form_dropdown('situation', $options, $selected, ['class' => 'form-control']);
        }

        //estamos editandoum anuncio

        $selected[] = match ($advertSituation) {
            self::SITUATION_NEW     => self::SITUATION_NEW,
            self::SITUATION_USED    => self::SITUATION_USED,

            default                 => throw new \Exception("Unsupported {$advertSituation}"),
        };

        return form_dropdown('situation', $options, $selected, ['class' => 'form-control']);
    }

    public function trySaveAdvert(Advert $advert, bool $protect = true, bool $notifyUserIfPublished = false) //  notifyUserIfPublished notifica o usuario quando o anuncio foi publicado
    {

        try {

            $advert->unsetAuxiliaryAtrributes();

            if ($advert->hasChanged()) {



                $this->advertModel->trySaveAdvert($advert, $protect);

                $this->fireAdvertEvents($advert, $notifyUserIfPublished);
            }
        } catch (\Exception $e) {
            //throw $th;
            die('code 10042 - Error saving data');
        }
    }

    public function tryStoreAdvertImages(array $images, int $advertID)
    {
        try {

            //recebe o id do anuncio que esta sendo editado
            $advert = $this->getAdvertByID($advertID);

            //armazena as imagens  em array $dataImages :storeImages('recebe as $images', 'na pasta adverts','propertyKey advert_id', recebe propertyValue '$advert->id' )
            $dataImages = ImageService::storeImages($images, 'adverts', 'adverts_id', $advert->id);


            //armazena no banco de dados as imagens
            $this->advertModel->tryStoreAdvertImages($dataImages, $advert->id);


            $this->fireAdvertEventForNewImages($advert);
        } catch (\Exception $e) {
            //throw $th;
            die('Error saving data');
        }
    }

    public function tryDeleteAdvertImage(int $advertID, string $image)
    {
        try {

            //recebe o id do anuncio que esta sendo editado
            $advert = $this->getAdvertByID($advertID);

            //armazena no banco de dados as imagens
            $this->advertModel->tryDeleteAdvertImage($image, $advert->id);

            ImageService::destroyImage('adverts', $image);
        } catch (\Exception $e) {
            //throw $th;
            die('Error deleting data 2');
        }
    }



    public function tryArchiveAdvert(int $advertID)
    {
        try {

            $advert = $this->getAdvertByID($advertID);

            $this->advertModel->tryArchiveAdvert($advert->id);
        } catch (\Exception $e) {
            //throw $th;
            die('Error archiving data');
        }
    }

    public function tryRecoverAdvert(int $advertID)
    {
        try {

            $advert = $this->getAdvertByID($advertID, withDeleted: true);

            $advert->recover();

            $this->trySaveAdvert($advert, protect: false);
        } catch (\Exception $e) {
            //throw $th;
            die('Error recovering data');
        }
    }

    public function tryDeleteAdvert(int $advertID)
    {

        //$image = [];

        try {

            $advert = $this->getAdvertByID($advertID, withDeleted: true);
            $images = $this->advertModel->getAdvertImages($advertID);

            foreach ($images as $img) {

                ImageService::destroyImage('adverts', $img->image);
            }

            $this->advertModel->tryDeleteAdvert($advertID);
        } catch (\Exception $e) {
            //throw $th;

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Error deleting data');
        }
    }

    public function getAllAdvertsPaginated(int $perPage = 10, array $criteria = []): array
    {

        return [

            'adverts'   => $this->advertModel->getAllAdvertsPaginated($perPage, $criteria),
            'pager'     => $this->advertModel->pager,
        ];
    }

    public function getAdvertByCode(string $code, bool $ofTheLoggedInUser = false)
    {
        $advert = $this->advertModel->getAdvertByCode($code,$ofTheLoggedInUser);

        if(is_null($advert)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Advert not found');
        }

        return $advert;
    }

    public function getCitiesFromPublishedAdverts(int $limit = 5, string $categorySlug = null):array
    {
        
        return $this->advertModel->getCitiesFromPublishedAdverts($limit,$categorySlug);

    }

    
    public function insertAdvertQuestion(Advert $advert, string $question)
{
    try {

        $this->advertModel->insertAdvertQuestion($advert->id,$question);
        
        session()->remove('ask');

/**
 * @todo dispara eventos para o anunciante
 * 
 */
        $this->fireAdvertHasNewQuestion($advert);
        
    } catch (\Exception $e) {
        //throw $th;

        log_message('error', '[ERROR] {exception}', ['exception' => $e]);

        die('Erro ao realizar pergunta');
    }

}

public function TryAnswerAdvertQuestion(int $questionID, Advert $advert, object $request)
{
    try {

       
        $this->advertModel->answerAdvertQuestion(questionID:$questionID, advertID:$advert->id, answer:$request->answer);      

        /**
         * @todo disparar eventopara quem perguntou
         */

         $this->fireAdvertQuestionHasBeenAnswered($advert, $request->question_owner);
       
    } catch (\Exception $e) {
        //throw $th;

        log_message('error', '[ERROR] {exception}', ['exception' => $e]);

        die('Erro ao respoder a pergunta');
    }

}


public function getAllAdvertByTerm(string $term = null):array
{

    $adverts=$this->advertModel->getAllAdvertByTerm($term);

    $data=[];

    foreach($adverts as $advert){
        $data[] = [
           'code'       => $advert->code,
           'value'      => $advert->title,
           'label'      => $advert->image(classImage:'image-autocomplete', sizeImage: 'small').' '.$advert->title,
        ];
    }

    return $data;

}

   

    //------------------------ METODOS PRIVADOS--------------------------//

    private function fireAdvertEvents(Advert $advert, bool $notifyUserIfPublished)
    {
        //se estiver sendo editado, entao o email ja possui valor quando da recuperacao do mesmo da base
        //se não tem valor, estamos criando novo anúncio, portanto, recebe o email do usuario logado

        $advert->email = !empty($advert->email) ? $advert->email : $this->user->email;

        if ($advert->hasChanged('title') || $advert->hasChanged('description')) {
            Events::trigger('notify_user_advert', $advert->email, "Estamos analisando o seu anúncio {$advert->code}, Obrigado, em breve seu anúncio esta disponivel no nosso site.");

            Events::trigger('notify_manager', "Existe anúncios para ser analisados");
        }
/**
 * @todo notificar o usuario/anunciante de que o anuncio foi publicado
 */
        if($notifyUserIfPublished){
            // chama a funcao fireAdvertPublished, se anuncio foi publicado.
            $this->fireAdvertPublished($advert);

        }

    }



    private function fireAdvertEventForNewImages(Advert $advert)
    {
        $advert->email = !empty($advert->email) ? $advert->email : $this->user->email;

        Events::trigger('notify_user_advert', $advert->email, "Estamos analisando as novas imagens do seu anúncio #{$advert->code}, Obrigado, em breve, as imagens do seu anúncio esta disponivel no nosso site, caso esteja de acordo com nossas politicas.");

        Events::trigger('notify_manager', "Existe anúncios para ser analisados... Novas imagens foram adicionadas");
    }

    private function fireAdvertHasNewQuestion(Advert $advert)
    {
        Events::trigger('notify_user_advert', $advert->email, "Seu anúncio {$advert->title} ... tem uma nova pergunta...");
    }

    private function fireAdvertQuestionHasBeenAnswered(Advert $advert, int $userQuestionID)
    {
        $userWhoAskedQuestion = Factories::class(UserService::class)->getUserByCriteria(['id'=> $userQuestionID]);

        Events::trigger('notify_user_advert', $userWhoAskedQuestion->email, "Sua pergunta que você fez para o anúncio {$advert->title}, foi respondida.");
    }

    private function fireAdvertPublished(Advert $advert)
    {
        if($advert->weMustNotifyThePublication()){

            Events::trigger('notify_user_advert', $advert->email, "Seu anúncio {$advert->title}, foi publicado.");

        }

    }
}
