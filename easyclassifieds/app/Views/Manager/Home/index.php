<?= $this->extend('Manager/Layout/main.php'); ?>

<?= $this->section('title')?>

<!-- Envio para o template principal os arquivos css e styles dessa view -->

<?php echo $title ?? '';?>

<?= $this->endsection()?>


<?= $this->section('styles')?>

<?= $this->endsection()?>


<?= $this->section('content')?>

<!-- Envio para o template principal o conteudo dessa view-->

<div class="container-fluid">
    <h1 class="mt-4"><?php echo $title ?? '';?></h1>   
    
</div>

<?= $this->endsection()?>


<?= $this->section('scripts')?>

<!-- Envio para o template principal os arquivos scripts dessa view-->

<?= $this->endsection()?>