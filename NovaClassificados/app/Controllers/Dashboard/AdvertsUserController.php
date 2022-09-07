<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Entities\Advert;
use App\Requests\AdvertRequest;
use App\Services\AdvertService;
use App\Services\CategoryService;
use App\Services\gerencianetService;
use App\Services\ImageService;
use CodeIgniter\Config\Factories;
use phpDocumentor\Reflection\Types\This;


class AdvertsUserController extends BaseController
{
    private $advertService;
    private $advertRequest;
    private $categoryService;

    public function __construct()
    {
        $this->advertService = Factories::class(AdvertService::class);
        $this->advertRequest = Factories::class(AdvertRequest::class);
        $this->categoryService = Factories::class(CategoryService::class);
    }

    public function index()
    {

        //dd($this->advertService->getAllAdverts());

        //(Factories::class(gerencianetService::class)->getUserSubscription());
        // d(Factories::class(gerencianetService::class)->countAllUserAdverts());
        // d(Factories::class(gerencianetService::class)->userReachedAdvertsLimit());

        return view('Dashboard/Adverts/index');
    }

    public function archived()
    {
       // dd($this->advertService->getArchivedAdverts());

        return view('Dashboard/Adverts/archived');
    }


    public function pending()
    {
        return view('Dashboard/Adverts/pending');
    }

    public function getUserArchivedAdverts()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $response = [

            'data' => $this->advertService->getArchivedAdverts(classBtnActions:'btn btn-sm btn-outline-info'),
        ];

        // return $this->response->setJSON(['data' => $this->advertService->getAllAdverts()]);

        return $this->response->setJSON($response);
    }

    public function getUserAdvertsNoPublished()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $response = [

            'data' => $this->advertService->getAllAdvertsNopublished(classBtnActions: 'btn btn-sm btn-outline-primary'),
        ];

        // return $this->response->setJSON(['data' => $this->advertService->getAllAdverts()]);

        return $this->response->setJSON($response);
    }

    public function getUserAdverts()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $response = [

            'data' => $this->advertService->getAllAdverts(classBtnActions: 'btn btn-sm btn-outline-primary'),
        ];

        // return $this->response->setJSON(['data' => $this->advertService->getAllAdverts()]);

        return $this->response->setJSON($response);
    }

    public function getUserAdvert()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }
        $advert = $this->advertService->getAdvertByID($this->request->getGetpost('id'));

        $options = [
            'class'         => 'form-control',
            'placeholder'   => lang('Categories.label_choose_category'),
            'selected'      => !(empty($advert->category_id)) ? $advert->category_id : "",
        ];

        $response = [

            'advert'         => $advert,
            'situations'     => $this->advertService->getDropdownSituations($advert->situation),
            'categories'     => $this->categoryService->getMultinivel('category_id', $options)
        ];

       
        return $this->response->setJSON($response);
    }

    public function updateUserAdvert()
    {
        $advert = $this->advertRequest->validateBeforeSave('advert');

        $advert = $this->advertService->getAdvertByID($this->request->getGetpost('id'));

        $advert->fill($this->removeSpoofingFromRequest());

        $this->advertService->trySaveAdvert($advert);

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_saved')));
    }

    public function getCategoriesAndSituations()
    {

        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $options = [
            'class'         => 'form-control',
            'placeholder'   => lang('Categories.label_choose_category'),
            'selected'      => "",
        ];

        $response = [

            'situations'     => $this->advertService->getDropdownSituations(),
            'categories'     => $this->categoryService->getMultinivel('category_id', $options)
        ];


        return $this->response->setJSON($response);
    }

    public function createUserAdvert()
    {
        $advert = $this->advertRequest->validateBeforeSave('advert');

        $advert = new Advert($this->removeSpoofingFromRequest());

        $this->advertService->trySaveAdvert($advert);

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_saved')));
    }

    public function editUserAdvertImages(int $id = null)
    {

        $data = [

            'advert'              => $advert = $this->advertService->getAdvertByID($id),
            'hiddens'             => ['_method' => 'PUT'], // para o upload de imagens(editando um anuncio)
            'hiddensDelete'       => ['id' => $advert->id, '_method' => 'DELETE'], // para remover as imagens do anuncio

        ];

        return view('Dashboard/Adverts/edit_images', $data);
    }

    public function uploadAdvertImages(int $id = null)
    {
        $this->advertRequest->validateBeforeSave('advert_images', repondWithRedirect: true);

        $this->advertService->tryStoreAdvertImages($this->request->getFiles('images'), $id);

        return redirect()->back()->with('success', lang('App.success_saved'));
    }

    public function deleteUserAdvertImage(string $image = null)
    {
        $this->advertService->tryDeleteAdvertImage($this->request->getGetpost('id'), $image);

        ImageService::destroyImage('adverts', $image);
        return redirect()->back()->with('success', lang('App.success_deleted'));
    }


    public function archiveUserAdvert()
    {

        $this->advertService->tryArchiveAdvert($this->request->getGetpost('id'));

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_archived')));
    }

    public function recoverUserAdvert()
    {

        $this->advertService->tryRecoverAdvert($this->request->getGetpost('id'));

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_recovered')));
    }

    public function deleteUserAdvert(string $image = null)
    {

        $this->advertService->tryDeleteAdvert($this->request->getGetpost('id'));


        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_deleted')));
    }
    
    public function UserAdvertQuestions(string $code = null)
    {
        $data = [

            'advert'              => $advert = $this->advertService->getAdvertByCode(code: $code, ofTheLoggedInUser: true),
            'hiddens'             => ['_method' => 'PUT', 'code' => $advert->code], // para responder as perguntas
       
        ];

        return view('Dashboard/Adverts/questions', $data);
    }

    
    public function UserAdvertAnswerQuestions(int $questionID = null)
    {

        $request = (object) $this->removeSpoofingFromRequest();
        
        $advert = $this->advertService->getAdvertByCode(code: $request->code, ofTheLoggedInUser: true);

        $this->advertService->tryAnswerAdvertQuestion(questionID: $questionID, advert: $advert, request: $request);
        
        return redirect()->back()->with('success', lang('App.success_saved'));
    
    }
    
}
