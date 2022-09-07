<script>
    // vai recupera o click no botao que criamos updateCategoryBtn

$(document).on('click','#createCategoryBtn', function(){

    $('input[name="_method"]').remove(); // e removemos o spoofing
    $('input[name="id"]').val(); // limpamos o id e não o removemos

    $('.modal-title').text('<?php echo lang('Categories.title_new'); ?>') //mudaremos depois com o lang
    $('#categoryModal').modal('show');
    
    $('#categories-form')[0].reset();
    $('#categories-form').attr('action','<?php echo route_to('categories.create'); ?>');
    $('#categories-form').find('span.error-text').text('');

    var url = '<?php echo route_to('categories.parents');?>'

    $.get(url, function(response){

    $('#boxParents').html(response.parents);
        
    },'json');
   

});
</script>