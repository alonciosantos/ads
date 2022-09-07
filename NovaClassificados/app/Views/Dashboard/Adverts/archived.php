
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
                        <div class="col-md-12">
                            
                        <!-- <a href="<?php //echo route_to('my.adverts') ?>" class=" btn btn-main-sm add-button mb-4 float-right"><?php //echo lang('App.btn_back');?></a> -->
                        
                        </div>    
                        <div class="col-md-12">
                            
                            <table class="table table-bordless table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        
                                        <th scope="col" class="all"><?php echo lang('Adverts.label_title');?></th>
                                        <th scope="col" class="none"><?php echo lang('Adverts.label_code');?></th>
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


   
    <?= $this->endsection()?>




<?= $this->section('scripts')?>


<!-- Envio para o template principal os arquivos scripts dessa view-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if($locale=="pt-BR"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_archived_pt'); }?>
<?php if($locale=="en"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_archived_en'); }?>
<?php if($locale=="es"){ echo $this->include('Dashboard/Adverts/Scripts/_datatable_all_archived_es'); }?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_recover_advert'); ?>
<?php echo $this->include('Dashboard/Adverts/Scripts/_delete_advert'); ?>


<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>

<?= $this->endsection()?>








    