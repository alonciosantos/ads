<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;

use App\Models\CategoryModel;

class CategoriesController extends BaseController
{
    public function index()
    {
        //
        $data =[
            'title' =>'Categorias',
        ];
        return view('Manager/Categories/index',$data);
        //return view('Manager/Categories/index',$data);
    }

    public function getAllCategories()
    {
        if(!$this->request->isAJAX()){

            return redirect()->back();
        }
        
        $categoryModel = new CategoryModel();

       // exit('categoria.get.all');

       $categories = $categoryModel->asObject()->orderBy('id','DESC')->findAll();
       $data=[];

       foreach($categories as $category){
       $data[]=[
        'id'           =>$category->id,
        'name'         =>$category->name,
        'slug'         =>$category->slug,
        'actions'      =>'<button class="btn btn-primary btn-sm">Ações</button>',
       ];
       }
       
       return $this->response->setJSON(['data'=>$data]);

    }

}