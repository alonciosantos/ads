<script>
    // vai recupera o click no botao que criamos updateCategoryBtn

$(document).on('click','#btnDeleteAdvert', function(e){

    e.preventDefault();

    var id = $(this).data('id');

    var url = '<?php echo route_to('adverts.manager.delete');?>'
    
    Swal.fire({
        title: '<?php echo lang('App.delete_confirmation');?>',
        text: '<?php echo lang('App.info_delete_confimation');?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<?php echo lang('App.btn_confirmed_delete');?>',
        cancelButtonText: '<?php echo lang('App.btn_cancel');?>'
     }).then((result) => {
        if (result.isConfirmed) {

            $.post(url,{
        '<?php echo csrf_token(); ?>' : $('meta[name="<?php echo csrf_token(); ?>"]').attr('content'), // sempre mandao o token ao fazer request
        _method:'DELETE', //spoofing do request

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
            
           /* Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )*/
        }
        })

   
        

});
</script>