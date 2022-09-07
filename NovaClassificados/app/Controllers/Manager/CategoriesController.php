<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Entities\Category;
use App\Requests\CategoryRequest;
use App\Services\CategoryService;
use CodeIgniter\Config\Factories;

use CodeIgniter\HTTP\Message;

class CategoriesController extends BaseController
{
    private $categoryService;
    private $categoryRequest;

    public function __construct()
    {
        $this->categoryService = Factories::class(CategoryService::class);
        $this->categoryRequest = Factories::class(CategoryRequest::class);
    }

    public function index()
    {
        //
        $data = [
            'title' => 'Categories',
        ];
        return view('Manager/Categories/index', $data);
    }

    public function archived()
    {
        //
        $data = [
            'title' => lang('Categories.label_archived'),
        ];
        return view('Manager/Categories/archived', $data);
    }

    public function getAllCategories()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        return $this->response->setJSON(['data' => $this->categoryService->getAllCategories()]);
    }

    public function getAllArchivedCategories()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        return $this->response->setJSON(['data' => $this->categoryService->getAllArchivedCategories()]);
    }

    public function getCategoryInfo()
        {
            if (!$this->request->isAJAX()) {
                return redirect()->back();
            }

            $category = $this->categoryService->getCategory($this->request->getGetPost('id'));

            $options= [
                'class' =>'form-control',
                'placeholder' =>  lang('Categories.label_choose_category'),
                'selected' => !(empty($category->parent_id))?$category->parent_id:"" //remove da lista Categoria Parent o id a ser editado
            ];

            $response=[
                'category' =>$category,
                'parents' =>$this->categoryService->getMultinivel('parent_id',$options,$category->id)
            ];
             
        return $this->response->setJSON($response);
    }

    public function create()
    {
        $this->categoryRequest->validateBeforeSave('category'); //so passar daqui se o formulario for validado
              
        $category = new Category($this->removeSpoofingFromRequest());

        $this->categoryService->trySaveCategory($category);
        
        //return $this->response->setJSON(['success' => true,'token'=>csrf_hash()]);
        return $this->response->setJSON($this->categoryRequest->respondWithMessage(message: lang('App.success_saved')));
    }

    
    public function update()
    {
        $this->categoryRequest->validateBeforeSave('category'); //so passar daqui se o formulario for validado

        $category = $this->categoryService->getCategory($this->request->getGetPost('id'));

                
        $category->fill($this->removeSpoofingFromRequest());

        $this->categoryService->trySaveCategory($category);
        
        //return $this->response->setJSON(['success' => true,'token'=>csrf_hash()]);
        return $this->response->setJSON($this->categoryRequest->respondWithMessage(message: lang('App.success_saved')));
    }

    public function archive()
    {
        
        $this->categoryService->tryArchiveCategory($this->request->getGetPost('id'));
        
        return $this->response->setJSON($this->categoryRequest->respondWithMessage(message:lang('App.success_archived')));
    }

      
    public function getDropdownParents()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        $options= [
            'class'         => 'form-control',
            'placeholder'   => lang('Categories.label_choose_category'),
            'selected'      => "" // estamos criando uma categoria
        ];

        $response=[
           
            'parents' =>$this->categoryService->getMultinivel('parent_id',$options)  //preenche o select com as categorias
        ];
         
    return $this->response->setJSON($response);

    }

    public function recover()
    {
        
        $this->categoryService->tryRecoverCategory($this->request->getGetPost('id'));
        
        return $this->response->setJSON($this->categoryRequest->respondWithMessage(message:lang('App.success_recovered')));
    }

    public function delete()
    {
        
        $this->categoryService->tryDeleteCategory($this->request->getGetPost('id'));
        
        return $this->response->setJSON($this->categoryRequest->respondWithMessage(message:lang('App.success_deleted')));
    }

  


    
}
