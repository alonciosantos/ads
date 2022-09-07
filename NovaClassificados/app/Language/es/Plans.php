<?php

/*return [

    'title_index'   => 'Listado de las categorías',
    'label_code'    => 'Código',
    'label_name'                 => 'Nombre',
    'label_is_highlighted'    => 'Destacado',
    'label_details'    => 'Detalles',
    'title_new'     => 'Crear un nuevo plan',
    'title_update'     => 'Plan de actualización',
    'title_edit'    => 'Editar plan',

    
    'label_choose_category'      => 'Elige una categoría',
    'label_slug'                 => 'Slug',
    'label_parent_name'          => 'categoría principal',

      //modal
      'label_recorrences' =>'Planes',
      'label_recorrence' =>'Seleccione el plan',
      'text_monthly' =>'Mensual',
      'text_quarterly' =>'Trimestral',
      'text_semester' =>'Semestral',
      'text_yearly' =>'Anual',
      'label_value' => 'Precio',
      'label_adverts' => 'Cantidad de anuncios',
      'label_description' => 'Descripción',
  

    // Validation
    'name'  => [
        'required'      => 'El nombre es Obligatorio',
        'min_length'    => 'El campo debe tener al menos 3 caracteres',
        'max_length'    => 'El campo debe tener un máximo de 90 caracteres',
        'is_unique'     => 'Este plan ya existe',
    ],

    // 
];*/

return [
  'title_index' => 'Listado de planes',
  'title_new' => 'Creando un nuevo plan',
  'title_edit' => 'Editando el Plan',
  'text_monthly' => 'Mensual',
  'text_quarterly' => 'Trimestral',
  'text_semester' => 'Semestre',
  'text_yearly' => 'Anual',
  'table_header_code' => 'Código',
  'table_header_plan' => 'Plan',
  'table_header_plan' => 'Plan',
  'table_header_details' => 'Detalles',
  'text_info_adverts' => 'Número de anuncios que el usuario puede registrar. Dejar en blanco para que sea ilimitado',
  'text_is_highlighted' => 'Destacado para comprar',
  'text_no_highlighted' => 'No resaltado para la compra',

  // Labels
  'label_name' => 'Nombre del plan',
  'label_code' => 'Código del plan',
  'label_recorrences' => 'Tipo de recurrencia',
  'label_recorrence' => 'Tipo de recurrencia',
  'label_adverts' => 'Número de anuncios permitidos',
  'label_value' => 'Valor del plan',
  'label_description' => 'Descripción del plan',
  'label_view' => 'Ver',
  'label_details' => 'Detalles',
  'label_is_highlighted' => 'Resaltar plan en Inicio',
  'label_free' => 'Publicado',
  'label_archived' => 'Archivado',

  // Validation messages
  'recorrence'        => [
      'in_list' => 'Elija una de las opciones: mensual, trimestral, semestral o anual',
  ],
];