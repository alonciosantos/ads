<?= $this->extend('Manager/Layout/main.php'); ?>

<?= $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endsection() ?>


<?= $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/r-2.3.0/datatables.min.css" />

<?= $this->endsection() ?>


<?= $this->section('content') ?>

<!-- Envio para o template principal o conteudo dessa view-->

<div class="container-fluid pt-3">


   <div class="row">

      <div class="col-md-8">

         <div class="card shadow-lg">
            <div class="card-header">
               <h5><?php echo $title ?? ''; ?></h5>
               
            </div>

            <div class="card-body">
               <a class="btn btn-primary btn-sm mt-2 mb-4" href="<?php echo route_to('categories');?>"><?php echo lang('App.btn_back');?></a>

               <table class="table table-borderless" id="dataTable">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo lang('Categories.label_name');?></th>
                        <th scope="col"><?php echo lang('Categories.label_slug');?></th>
                        <th scope="col"><?php echo lang('App.btn_actions');?></th>
                     </tr>
                  </thead>

               </table>
            </div>

         </div>

      </div>

   </div>
</div>





<?= $this->endsection() ?>


<?= $this->section('scripts') ?>
<!-- Envio para o template principal os arquivos scripts dessa view-->

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/r-2.3.0/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if($locale=="en"){ echo $this->include('Manager/Categories/Scripts/_datatable_all_archived_en'); }?>
<?php if($locale=="es"){ echo $this->include('Manager/Categories/Scripts/_datatable_all_archived_es'); }?>
<?php if($locale=="pt-BR"){ echo $this->include('Manager/Categories/Scripts/_datatable_all_archived_pt'); }?>
<?php echo $this->include('Manager/Categories/Scripts/_recover_category'); ?>
<?php echo $this->include('Manager/Categories/Scripts/_delete_category'); ?>



<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>

<?= $this->endsection() ?>