<?php
/*
return [

    'title_index'   => 'Listado de los planes',
    'label_code'    => 'Código',
    'label_name'    => 'Nome',
    'label_is_highlighted'    => 'Em destaque',
    'label_details'    => 'Detalhes',
    'title_new'     => 'Criar um novo plano',
    'title_update'     => 'Atualizar plano',
    'title_edit'    => 'Editar categoria',

    //modal
    'label_recorrences' =>'Planos',
    'label_recorrence' =>'Selecione o plano',
    'text_monthly' =>'Mensal',
    'text_quarterly' =>'Trimestral',
    'text_semester' =>'Semestral',
    'text_yearly' =>'Anual',
    'label_value' => 'Preço',
    'label_adverts' => 'Qtde de Anuncios',
    'label_value' => 'Preço',
    'label_description' => 'Descrição',


   
    // Validation
    'name'  => [
        'required'      => 'O nome é Obrigatorio',
        'min_length'    => 'O campo deve ter pelo menos 3 caracteres',
        'max_length'    => 'O campo deve ter  no maximo 90 caracteres',
        'is_unique'     => 'Essa categoria já existe',
    ],

    // 
];*/

return [
    'title_index'                   => 'Listando os Planos',
    'title_new'                     => 'Criando novo Plano',
    'title_edit'                    => 'Editando o Plano',
    'text_monthly'                  => 'Mensal',
    'text_quarterly'                => 'Trimestral',
    'text_semester'                 => 'Semestral',
    'text_yearly'                   => 'Anual',
    'text_info_adverts'             => 'Nº de Anúncios que o usuário poderá cadastrar. Deixe em branco para ilimitado',
    'text_is_highlighted'           => 'Destacado para compra',
    'text_no_highlighted'           => 'Não destacado para compra',
    'text_unlimited_adverts'        => 'Ilimitado',


    // btn
    'btn_choice'    => 'Eu quero esse',


    // Table view
    'table_header_code'     => 'Código',
    'table_header_plan'     => 'Plano',
    'table_header_details'  => 'Detalhes',

    // Labels
    'label_name'            => 'Nome do Plano',
    'label_code'            => 'Códido do Plano',
    'label_recorrence'      => 'Tipo de recorrência',
    'label_adverts'         => 'Nº de Anúncios permitidos',
    'label_value'           => 'Valor do plano',
    'label_description'     => 'Descrição do plano',
    'label_view'            => 'Visualizar',
    'label_details'         => 'Detalhes',
    'label_is_highlighted'  => 'Plano Destacado para Compra',
    'label_archived'        => 'Arquivado',

    // Validation messages
    'recorrence'        => [
        'in_list' => 'Por favor escolha uma das opções: Mensal, Trimestral, Semestral ou Anual',
    ],
];
