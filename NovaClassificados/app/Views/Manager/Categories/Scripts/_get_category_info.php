<script>
    // vai recupera o click no botao que criamos updateCategoryBtn

$(document).on('click','#updateCategoryBtn', function(){
    $('input[name="_method"]').remove(); // remove input _method ao clicar em editar
    
    var id = $(this).data('id');
    var url = '<?php echo route_to('categories.get.info');?>'
    $.get(url,{

        id:id

    }, function(response){

        $('#categoryModal').modal('show');

        $('.modal-title').text('<?php echo lang('Categories.title_update'); ?>') //mudaremos depois com o lang
        $('#categories-form').attr('action','<?php echo route_to('categories.update'); ?>');
        $('#categories-form').find('input[name="id"]').val(response.category.id);
        $('#categories-form').find('input[name="name"]').val(response.category.name);
        $('#categories-form').append("<input type='hidden' name='_method' value='PUT'>"); //spoofing falsifica o metodo POST como PUT
        $('#boxParents').html(response.parents);
        $('#categories-form').find('span.error-text').text('');


    },'json');
   

});
</script>