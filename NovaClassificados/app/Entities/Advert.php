<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use phpDocumentor\Reflection\Types\Boolean;

class Advert extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at','user_since']; ///user_since = tempo desde a plublicação  2 horas atras, 1 dia tras 
    protected $casts   = [
        'is_published'    => 'boolean', // true ou false
        'adverts'         => '?integer', // inteiro ou nulo
        'display_phone'   => 'boolean', // true ou false exibe o telefone do anunciante
    ];

    public function setPrice(string $price) //metodo invocado automaticamente
    {
        $this->attributes['price'] = str_replace(',','',$price);
        
    }

    // esse metodo sera utilizado pelo manager para publicar ou um anuncio
    public function setIsPublished(string $isPublished) //metodo invocado automaticamente
    {
        $this->attributes['is_published'] = $isPublished ? true : false;
        
    }

    public function recover()
    {
        $this->attributes['deleted_at'] = null;
    }
    

    public function unsetAuxiliaryAtrributes()
    {
       //unset($this->attributes['address']);
        unset($this->attributes['images']);
    }

    public function isPublished()
    {
     $is_published = '<span class="badge badge-success btn-sm">'.lang('Adverts.text_is_published').'</span>';
     $under_analysis = '<span class="badge badge-warning btn-sm">'.lang('Adverts.text_under_analysis').'</span>';

       return $this->attributes['is_published'] ? $is_published : $under_analysis;
 
    }

    public function address()
    {
        $number = !empty($this->attributes['number'] ) ? $this->attributes['number'] : 'S/N';
        $street = $this->attributes['street'];
        $address = $street.', '.$number;

        return "{$this->attributes['street']} - {$number}, {$this->attributes['neighborhood']} - {$this->attributes['zipcode']}  - {$this->attributes['city']} - {$this->attributes['state']}";
    }

    public function image(string $classImage ='',string $sizeImage = 'regular'):string
    {

        //sem imagem
        if(empty($this->attributes['images'])){ //linha 366 AdvertModel.php que pegara o atributo definido 'adverts_images AS images'

            return $this->handleWithEmptyImage($classImage);

        }              
        // uma imagem
        if(is_string($this->attributes['images'])){//linha 366 AdvertModel.php que pegara o atributo definido 'adverts_images AS images'

            return $this->handleWithSingleImage($classImage, $sizeImage);

        }
        // array de images
        if(url_is('api/adverts*')){

            return $this->handleWithImagesForAPI();

        }
    }

    public function price() // exibir o sifrão R$ no preço do anuncio na home
    {
        return number_to_currency($this->attributes['price'],'BRL','pt-BR',2);
    }

    public function situation():string
    {
        return $this->attributes['situation'] === 'new' ? '<span class = "badge badge-success">Novo</span>' : '<span class="badge badge-secundary">Usado</span>';
    }

    public function displayPhone():bool{
        return $this->attributes['display_phone'];
    }

    public function city()
    {
        return "{$this->attributes['city']} - {$this->attributes['state']}";
    }

    
    public function weMustNotifyThePublication():bool // quando nos podemos notificar a publicação ao anuniciante
    {
       $originalIspublished = (bool) $this->original['is_published'];
    
       return $originalIspublished===false && $this->attributes['is_published']; // resultado obtido true ou false
    }

    private function handleWithEmptyImage(string $classImage):string
    {
        if(url_is('api/adverts*')){

            return site_url('image/advert-no-image.png');
        }

        return img(
            [
                'src'       => route_to('web.image','advert-no-image.png','regular'),
                'alt'       => 'No image yet',
                'title'     => 'No image yet',
                'class'     => $classImage,
                
            ]
        );
    }

    private function handleWithSingleImage(string $classImage, string $sizeImage ):string
    {
        if(url_is('api/adverts*')){

            return $this->buildRouteForImageAPI($this->attributes['images']);                      
            
        }

        return img(
            [
                'src'       => route_to('web.image',$this->attributes['images'],$sizeImage),
                'alt'       => $this->attributes['title'],
                'title'     => $this->attributes['title'],
                'class'     => $classImage, 
            ]
        );
    }

    private function handleWithImagesForAPI():array
    {
        $images =[];

        foreach($this->attributes['title'] as $image){

            $images[] =$this->buildRouteForImageAPI($image->image);

        }

       return $images;
       
    }

    private function buildRouteForImageAPI(string $image):string
    {
        return site_url("image/{$image}");

    }

    
}
