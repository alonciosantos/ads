<?php

return [

    'title_index'   => 'Lista de Categorias',
    'title_new'     => 'Criar uma nova categoria',
    'title_update'     => 'Atualizar categoria',
    'title_edit'    => 'Editar categoria',

    'label_name'                 => 'Nome',
    'label_archived'             => 'Lista de Categorias Arquivadas',
    'label_choose_category'      => '--- Escolha uma categoria ---',
    'label_slug'                 => 'Slug',
    'label_parent_name'          => 'Categoria pai',

    // Validation
    'name'  => [
        'required'      => 'O nome é Obrigatorio',
        'min_length'    => 'O campo deve ter pelo menos 3 caracteres',
        'max_length'    => 'O campo deve ter  no maximo 90 caracteres',
        'is_unique'     => 'Essa categoria já existe',
    ],

    // 
];