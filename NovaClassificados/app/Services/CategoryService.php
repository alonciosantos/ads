<?php

namespace App\Services;

use App\Entities\Category;
use App\Models\CategoryModel;
use CodeIgniter\Config\Factories;
use Config\App;
use App\Language;

class CategoryService
{
    private  $categoryModel;

    public function __construct()
    {
        $this->categoryModel = Factories::models(CategoryModel::class);
    }

    //public function getAllCategories(bool $withDeleted = false): array
    public function getAllCategories(): array
    {

        // foi adicionado a funcao withDeleted como null/false para exibir apenas categorias marcadas como nao deletada
        //$categories = $this->categoryModel->asObject()->orderBy('id', 'DESC')->withDeleted($withDeleted)->findAll();
       
        $categories = $this->categoryModel->asObject()->orderBy('id', 'DESC')->findAll();

        $data = [];
        

        foreach ($categories as $category) {

            $btnEdit = form_button(
                [
                    'data-id' => $category->id,
                    'id'      => 'updateCategoryBtn', // ID do htm element
                    'class'   => 'btn btn-primary btn-sm'
                ],
                lang('App.btn_edit')
            );

            $btnArchive = form_button(
                [
                    'data-id' => $category->id,
                    'id'      => 'archiveCategoryBtn', // ID do htm element
                    'class'   => 'btn btn-info btn-sm'
                ],
                lang('App.btn_archive')
            );

            $data[] = [
                'id'           => $category->id,
                'name'         => $category->name,
                'slug'         => $category->slug,
                'action'      => $btnEdit . '  ' . $btnArchive,
            ];

            
        }

        return $data;
    }

    //public function getAllArchivedCategories(bool $withDeleted = true): array
    
    public function getAllArchivedCategories(): array
    {

        // foi adicionado a funcao withDeleted como null/false para exibir apenas categorias marcadas como nao deletada
        //$categories = $this->categoryModel->asObject()->onlyDeleted()->orderBy('id', 'DESC')->withDeleted($withDeleted)->findAll();

        $categories = $this->categoryModel->asObject()->onlyDeleted()->orderBy('id', 'DESC')->findAll();

        $data = [];

        foreach ($categories as $category) {

            $btnRecover = form_button(
                [
                    'data-id' => $category->id,
                    'id'      => 'recoverCategoryBtn', // ID do htm element
                    'class'   => 'btn btn-primary btn-sm'
                ],
                lang('App.btn_recovery')
            );
            $btnDelete = form_button(
                [
                    'data-id' => $category->id,
                    'id'      => 'deleteCategoryBtn', // ID do htm element
                    'class'   => 'btn btn-danger btn-sm'
                ],
                lang('App.btn_del')
            );

            $data[] = [
                'id'           => $category->id,
                'name'         => $category->name,
                'slug'         => $category->slug,
                'action'      => $btnRecover . '  ' . $btnDelete,
            ];
        }

        return $data;
    }


    /** 
     *  Recupera  a categoria de acordo com o ID
     * @param interger $id
     * @param boolean $withDeleted
     * @throws Exception 
     * @return null|Category
     */
    
    public function getCategory(int $id, bool $withDeleted = false){
      
        $category = $this->categoryModel->withDeleted($withDeleted)->find($id);

        if(is_null($category)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found!');

        }
        
        return $category;
    }
    public function getMultinivel(string $name, $options = [], int $exceptCategoryID = null, bool $withDeleted = false)
    {

       // $array = $this->categoryModel->asArray()->orderBy('id', 'DESC')->withDeleted($withDeleted)->findAll();
       $array = $this->categoryModel->getParentCategories($exceptCategoryID);

        $class_form = "";
        if (isset($options['class'])) {
            $class_form = $options['class'];
        }

        $selected = [];


        if (isset($options['selected'])) {
            $selected = is_array($options['selected']) ? $options['selected'] : [$options['selected']];
        }

        if (isset($options['placeholder'])) {
            $placeholder = [
                'id' => '',
                'name' => $options['placeholder'],
                'parent_id' => 0
            ];
            $array[] = $placeholder;
        }

        $multiple = '';
        if (isset($options['multiple'])) {
            $multiple = 'multiple';
        }

        $select = '<select class="' . $class_form . '" name="' . $name . '" ' . $multiple . '>';
        $select .= $this->getMultiLevelOptions($array, 0, [], $selected);
        $select .= '</select>';

        return $select;
    }

    public function getMultiLevelOptions(array $array, $parent_id = 0, $parents = [], $selected = [])
    {
        static $i = 0;
        if ($parent_id == 0) {
            foreach ($array as $element) {
                if (($element['parent_id'] != 0) && !in_array($element['parent_id'], $parents)) {
                    $parents[] = $element['parent_id'];
                }
            }
        }

        $menu_html = '';
        foreach ($array as $element) {
            $selected_item = '';
            if ($element['parent_id'] == $parent_id) {
                if (in_array($element['id'], $selected)) {
                    $selected_item = 'selected';
                }
                $menu_html .= '<option value="' . $element['id'] . '" ' . $selected_item . '>';
                for ($j = 0; $j < $i; $j++) {
                    $menu_html .= '&mdash; ';
                }
                $menu_html .= $element['name'] . '</option>';
                if (in_array($element['id'], $parents)) {
                    $i++;
                    $menu_html .= $this->getMultilevelOptions($array, $element['id'], $parents, $selected);
                }
            }
        }

        $i--;
        return $menu_html;
    }
    public function trySaveCategory(Category $category, bool $protect =true)
    {
        try{

            if($category->hasChanged()){

                $this->categoryModel->protect($protect)->save($category);
               

            }

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }

    public function tryArchiveCategory(int $id)
    {
        try{

            $category=$this->getCategory($id);

            $this->categoryModel->delete($category->id); // deletando a categoria atraves do id

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }
    public function tryRecoverCategory(int $id)
    {
        try{

            $category=$this->getCategory($id, withDeleted: true); //paga as categorias marcadas como deletada

            $category->recover(); //recupera a categoria marcando como null no banco de dados

            $this->trySaveCategory($category, protect: false);



        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }
    public function tryDeleteCategory(int $id)
    {
        try{

            $category=$this->getCategory($id, withDeleted: true); //paga as categorias marcadas como deletada

            $this->categoryModel->delete($category->id, purge:true); //deleta permanente da categoria

        }catch(\Exception $e){

            //logar os erros

            die($e->getMessage());// mensagem apenas para os desenvolvedores
           // die('Erro ao salvar os dados');

        }

    }

    public function getCategoryBySlug(string $categorySlug, bool $withDeleted = false)
    {
        $category = $this->categoryModel->withDeleted($withDeleted)->where('slug', $categorySlug)->first();

        if(is_null($category)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }

        return $category;
    }

    public function getCategoriesFromPublishedAdverts(int $limit = 5):array
    {

        return $this->categoryModel->getCategoriesFromPublishedAdverts($limit);
    }
}

