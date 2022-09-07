
<?= $this->extend('Dashboard/Layout/main'); ?>

<?= $this->section('title')?>


<?php echo lang('Adverts.title_index');?>

<?= $this->endsection()?>


<?= $this->section('styles')?>
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

<section class="dashboard section">
        <!-- Container Start -->
        <div class="container">
            <!-- Row Start -->
            <div class="row">

            <?php  echo $this->include('Dashboard/Layout/_sidebar');?>
                                
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
                    <!-- Recently Favorited -->
                    <div class="widget dashboard-container my-adslist">
                        <h3 class="widget-header"><?php echo lang( 'Adverts.title_index'); ?></h3>
                     
                        <div class="row">

                        <?php if(user_reached_adverts_limit()):?>

                         <div class=" alert alert-info small" id="alert">
                            Voçê já cadastrou <?php echo count_all_user_adverts();?> anúncio(s). Para continuar cadastrando voçê pode migrar de plano.
                            <a href="<?php echo route_to('pricing') ;?>" class="btn btn-info btn-sm mt-3">Quero Migrar</a>
                         </div>
                        <?php else: ?>
                            <div class=" alert alert-info small">
                            Voçê já cadastrou <?php echo count_all_user_adverts();?> anúncio(s). Para continuar cadastrando voçê pode migrar de plano.
                            <a href="<?php echo route_to('pricing') ;?>" class="btn btn-info btn-sm mt-3">Quero Migrar</a>
                         </div>

                            <div class="col-md-12">
                        <button type="button" id="createAdvertBtn" class=" btn btn-main-sm add-button mb-4 float-right" ><i class=" fa fa-plus-circle"></i> <?php echo lang('Adverts.btn_new');?></button>
                        </div> 

                        <?php endif;?>

                        <div class="col-md-12">
                            
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
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </section>


    <?php echo $this->include('Dashboard/Adverts/_modal_advert'); ?>

    <?= $this->endsection()?>




<?= $this->section('scripts')?>


<!-- Envio para o template principal os arquivos scripts dessa view-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/jquery.mask.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/app.js');?>"></script>

<?php if($locale=="pt-BR"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_pt'); }?>
<?php if($locale=="en"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_en'); }?>
<?php if($locale=="es"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_es'); }?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_get_my_advert'); ?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_show_modal_to_create'); ?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_submit_modal_create_update'); ?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_viacep'); ?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_archive_advert'); ?>

<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>

<?= $this->endsection()?>








    