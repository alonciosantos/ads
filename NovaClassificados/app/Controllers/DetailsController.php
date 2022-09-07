<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AdvertService;
use App\Services\ImageService;
use CodeIgniter\Config\Factories;

class DetailsController extends BaseController
{
    private $advertService;

    public function __construct()
    {

        $this->advertService = Factories::class(AdvertService::class);
    }


    public function image(string $image = null, string $sizeImage = 'regular')
    {
        ImageService::showImage('adverts', $image, $sizeImage);
    }

    public function details(string $code = null)
    {
        $advert = $this->advertService->getAdvertByCode($code); // detalha o anuncio atraves do codigo do anucnio

        /**
         * @todo criar metodo para recuperar mais anúncios da mesna categoaria
         */

        $criteria = [
            'categories.slug' => $advert->category_slug,
            'adverts.code !=' => $advert->code,
        ];

        $advertsFromSemiCategory = (object)$this->advertService->getAllAdvertsPaginated(perPage: 10, criteria: $criteria);

        $data = [
            'title'         =>  "Detalhes do Anúncio {$advert->title}",
            'advert'        =>  $advert,
            'moreAdverts'   =>  $advertsFromSemiCategory->adverts, //enviamos mais anuncio da mesma categoria
            'pager'         =>  $advertsFromSemiCategory->pager,

            
        ];

        

        return view('Web/Details/index', $data);
    }

    public function toask(string $code = null)
    {
        $advert = $this->advertService->getAdvertByCode($code);

        if($advert->user_id == service('auth')->user()->id){

            return \redirect()->back()->with('info_ask','Este anúncio pertence a voçê, a pergunta será ignorada!');
        }

        $this->advertService->tryInsertAdvertQuestion($advert,$this->request->getPost('ask'));
        return \redirect()->back()->with('success_ask','Sua pergunta foi enviada com sucesso!');
        
    }
}

