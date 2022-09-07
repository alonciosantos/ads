<script>
    // vai recupera o click no botao que criamos updateCategoryBtn

$(document).on('click','#createPlanBtn', function(){

    
    $('.modal-title').text('<?php echo lang('Plans.title_new') ?>') //mudaremos depois com o lang
    $('#modalPlan').modal('show');

    $('input[name="_method"]').remove(); // e removemos o spoofing
    $('input[name="id"]').val(); // limpamos o id e não o removemos
    
    $('#plans-form')[0].reset();
    $('#plans-form').attr('action','<?php echo route_to('plans.create'); ?>');
    $('#plans-form').find('span.error-text').text('');

    var url = '<?php echo route_to('plans.get.recorrences');?>'

    $.get(url, function(response){

    $('#boxRecorrences').html(response.recorrences);
        
    },'json');
   

});
</script>