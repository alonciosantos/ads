<?php

return [

   
    'title_index'   => 'Listado de las categorías',
    'title_new'     => 'Crear una nueva categoría',
    'title_update'     => 'Categoría de actualización',
    'title_edit'    => 'Editar categoria',

    'label_name'                 => 'Nombre',
    'label_choose_category'      => 'Elige una categoría',
    'label_slug'                 => 'Slug',
    'label_parent_name'          => 'Categoría principal',

    // Validation
    'name'  => [
        'required'      => 'El nombre es Obligatorio',
        'min_length'    => 'El campo debe tener al menos 3 caracteres',
        'max_length'    => 'El campo debe tener un máximo de 90 caracteres',
        'is_unique'     => 'Esta categoría ya existe',
    ],

    // 
];