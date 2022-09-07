<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use CodeIgniter\Config\Factories;
use App\Services\AdvertService;
use App\Requests\AdvertRequest;
use App\Services\CategoryService;

class AdvertsManagerController extends BaseController
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
        return view('Manager/Adverts/index');
    }

    
    public function archived()
    {
        return view('Manager/Adverts/archived');
    
    }

    public function getManagerArchivedAdverts()
    {
        if (!$this->request->isAJAX()) {

            return redirect()->back();
        }

        $response = [

            'data' => $this->advertService->getArchivedAdverts(showBtnRecover: false,classBtnActions:'btn btn-sm btn-outline-info'),
        ];

        // return $this->response->setJSON(['data' => $this->advertService->getAllAdverts()]);

        return $this->response->setJSON($response);
    }
    public function getAllAdvertsManager()
    {
        
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $response =[
            'data' => $this->advertService->getAllAdvertsManager(showBtnArvhive:true,showBtnQuestions:false, classBtnActions: 'btn btn-sm btn-outline-primary'),
            
            
        ];

        return $this->response->setJSON($response);
    

    }

    public function getManagerAdvert()
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
            'categories'     => $this->categoryService->getMultinivel('category_id', $options),
           // 'is_published'  =>  !($advert->is_published)? "":"cheked",
        ];

        //dd($response);


        return $this->response->setJSON($response);
    }

    
    public function updateManagerAdvert()
    {
        $advert = $this->advertRequest->validateBeforeSave('advert');

        $advert = $this->advertService->getAdvertByID($this->request->getGetpost('id'));

        $advert->fill($this->removeSpoofingFromRequest());

        $this->advertService->trySaveAdvert($advert, protect:false, notifyUserIfPublished:true);

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_saved')));
    
    
    }
    
    public function archiveManagerAdvert()
    {
        $this->advertService->tryArchiveAdvert($this->request->getGetpost('id'));

        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_archived')));
     
    }

    public function deleteManagerAdvert()
    {

        $this->advertService->tryDeleteAdvert($this->request->getGetpost('id'));


        return $this->response->setJSON($this->advertRequest->respondWithMessage(message: lang('App.success_deleted')));
    }

    public function showManagerAdvertImages(int $id = null)
    {

        $data = [

            'advert'              => $advert = $this->advertService->getAdvertByID($id),
            
        ];

        return view('Manager/Adverts/show_images', $data);
    }
}
