
<?= $this->extend('Manager/Layout/main'); ?>

<?= $this->section('title')?>


<?php echo lang('Adverts.title_index');?>

<?= $this->endsection()?>


<?= $this->section('styles')?>



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
                        
                    <a href="<?php echo route_to('adverts.manager') ;?>" class="btn btn-main-sm btn-outline-info mb-4"><?php echo lang('App.btn_back') ;?></a>
                            
                            <table class="table table-bordless table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="all"><?php echo lang('Adverts.label_title');?></th>
                                        <th scope="col" class="all"><?php echo lang('Adverts.label_code');?></th>
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
   
    <?= $this->endsection()?>




<?= $this->section('scripts')?>


<!-- Envio para o template principal os arquivos scripts dessa view-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if($locale=="pt-BR"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_archived_pt'); }?>
<?php if($locale=="en"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_archived_en'); }?>
<?php if($locale=="es"){ echo $this->include('Manager/Adverts/Scripts/_datatable_all_archived_es'); }?>
<?php echo $this->include('Manager/Adverts/Scripts/_recover_advert'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_delete_advert'); ?>


<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>

<?= $this->endsection()?>








    