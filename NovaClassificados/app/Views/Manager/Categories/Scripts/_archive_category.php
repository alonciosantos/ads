<script>
    // vai recupera o click no botao que criamos updateCategoryBtn

$(document).on('click','#archiveCategoryBtn', function(){

    var id = $(this).data('id');

    var url = '<?php echo route_to('categories.archive');?>'

    $.post(url,{
        '<?php echo csrf_token(); ?>' : $('meta[name="<?php echo csrf_token(); ?>"]').attr('content'), // sempre mandao o token ao fazer request
        _method:'PUT', //spoofing do request

        id:id

        }, function(response){
            
            window.refreshCSRFToken(response.token);

            // Display a success toast, with a title
            toastr.success(response.message);
          
            //atualizar a tabela dinamicamente
            $("#dataTable").DataTable().ajax.reload(null,false);

        },'json').fail(function(){

            toastr.error('Error backend');

        });
        

});
</script>