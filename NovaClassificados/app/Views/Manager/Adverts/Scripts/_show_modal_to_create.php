<script>

    $(document).on('click', '#createAdvertBtn', function(){

    

    $('.modal-title').text('<?php echo lang('Adverts.title_new'); ?>') //mudaremos depois com o lang
    $('#modalAdvert').modal('show');

    $('input[name="_method"]').remove(); // e removemos o spoofing
    $('input[name="id"]').val(); // limpamos o id e não o removemos
    
    $('#adverts-form')[0].reset();
    $('#adverts-form').attr('action','<?php echo route_to('adverts.create.my'); ?>'); // action vazio verificar aqui as rotas se esta certo
    $('#adverts-form').find('span.error-text').text('');


    
     // fazer o ajax request para buscar as situações e categorias
    
     var url = '<?php echo route_to('get.categories.situations');?>'

    $.get(url, function(response){

    $('#boxSituations').html(response.situations);
    $('#boxCategories').html(response.categories);
        
    },'json').fail(function(){

        toastr.error("We couldn't create the ad.")
    });

    });
</script>