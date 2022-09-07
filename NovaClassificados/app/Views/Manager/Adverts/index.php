
<?= $this->extend('Manager/Layout/main'); ?>

<?= $this->section('title')?>


<?php echo lang('Adverts.title_index');?>

<?= $this->endsection()?>


<?= $this->section('styles')?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    select {
        height: 50px !important;
    }

    #dataTable_filter .form-control {
        height: 30px !important;
    }
/**
* criamos a classe .modal-xl que não tem nessa versao do bootstrap
*/
    @media(min-width:1200px){
        .modal-xl{
            max-width: 1140px;
        }
    }
</style>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css"/>
 



<?= $this->endsection()?>


<?= $this->section('content')?>

<!-- Envio para o template principal o conteudo dessa view-->

 <!-- Container Start -->
 <div class="container-fluid">
            <!-- Row Start -->
            <div class="row">

            
                                
                <div class="col-md-12 ">

                <div class="card shadow-lg">
                    <div class="card-header">
                        <h5><?php echo lang( 'Adverts.title_index'); ?></h5>
                    </div>
                    <div class="card-body">
                        
                    <a href="<?php echo route_to('adverts.manager.archived') ;?>" class="btn btn-main-sm btn-outline-info mb-4"><?php echo lang('App.btn_adverts_all_archived') ;?></a>
                            
                            <table class="table table-bordless table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo lang('Adverts.label_image');?></th>
                                        <th scope="col" class="all"><?php echo lang('Adverts.label_title');?></th>
                                        <th scope="col" class="none"><?php echo lang('Adverts.label_code');?></th>
                                        <th scope="col" class="none text-center"><?php echo lang('Adverts.label_category');?></th>
                                        <th scope="col"><?php echo lang('Adverts.label_status');?></th>
                                        <th scope="col" class="none"><?php echo lang('Adverts.label_address');?></th>
                                        <th scope="col" class="all text-center"><?php echo lang('App.btn_actions');?></th>
                                    </tr>
                                </thead>

                            </table>
                    </div>


                </div>
                                    
                </div>
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->


    <?php echo $this->include('Manager/Adverts/_modal_advert'); ?>

    <?= $this->endsection()?>




<?= $this->section('scripts')?>


<!-- Envio para o template principal os arquivos scripts dessa view-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/jquery.mask.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/app.js');?>"></script>

<?php if($locale=="pt-BR"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_pt'); }?>
<?php if($locale=="en"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_en'); }?>
<?php if($locale=="es"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_es'); }?>
<?php echo $this->include('Manager/Adverts/Scripts/_get_manager_advert'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_show_modal_to_create'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_submit_modal_create_update'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_viacep'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_archive_advert'); ?>

<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>

<?= $this->endsection()?>








    