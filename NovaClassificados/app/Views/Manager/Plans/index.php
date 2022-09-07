<?= $this->extend('Manager/Layout/main.php'); ?>

<?= $this->section('title') ?>

<?php echo lang('Plans.title_index'); ?>

<?= $this->endsection() ?>


<?= $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/r-2.3.0/datatables.min.css" />

<?= $this->endsection() ?>


<?= $this->section('content') ?>

<!-- Envio para o template principal o conteudo dessa view-->

<div class="container-fluid pt-3">


   <div class="row">

      <div class="col-md-12">

         <div class="card shadow-lg">
            <div class="card-header">
               <h5><?php echo lang('Plans.title_index'); ?></h5>
               <button id="createPlanBtn" class="btn btn-success btn-sm float-end"><?php echo lang('Plans.title_new'); ?></button>
            </div>

            <div class="card-body">
               <a class="btn btn-info btn-sm mt-2 mb-4" href="<?php echo route_to('plans.archived');?>"><?php echo lang('app.btn_all_archived_plans'); ?></a>

               <table class="table table-borderless" id="dataTable">
                  <thead>
                     <tr>
                        <th scope="col"><?php echo lang('Plans.label_code'); ?></th>
                        <th scope="col"><?php echo lang('Plans.label_name'); ?></th>
                        <th scope="col"><?php echo lang('Plans.label_is_highlighted'); ?></th>
                        <th scope="col"><?php echo lang('Plans.label_details'); ?></th>
                        <th scope="col"><?php echo lang('App.btn_actions');?></th>
                     </tr>
                  </thead>

               </table>
            </div>

         </div>

      </div>

   </div>
</div>


<?php echo $this->include('Manager/Plans/_modal_plan');?>

<?= $this->endsection() ?>


<?= $this->section('scripts') ?>
<!-- Envio para o template principal os arquivos scripts dessa view-->


<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/jquery.mask.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('manager_assets/mask/app.js');?>"></script>

<?php if($locale=="en"){ echo $this->include('Manager/Plans/Scripts/_datatable_all_en'); }?>
<?php if($locale=="es"){ echo $this->include('Manager/Plans/Scripts/_datatable_all_es'); }?>
<?php if($locale=="pt-BR"){ echo $this->include('Manager/Plans/Scripts/_datatable_all_pt'); }?>

<?php echo $this->include('Manager/Plans/Scripts/_show_modal_to_create'); ?>
<?php echo $this->include('Manager/Plans/Scripts/_submit_modal_create_update'); ?>
<?php echo $this->include('Manager/Plans/Scripts/_get_plan_info'); ?>
<?php echo $this->include('Manager/Plans/Scripts/_archive_plan'); ?>

<?php //echo $this->include('Manager/Plans/Scripts/_datatable_all');?>



<script>
<?php //atualiza o token acada submit para receber um novo token para proxima submit, pois codeignter gera um token a cada requisicao ?>
function refreshCSRFToken(token){

   $('[name="<?php echo csrf_token(); ?>"]').val(token);
   $('meta[name="<?php echo csrf_token(); ?>"]').attr('content',token);
}

</script>



<?= $this->endsection() ?>