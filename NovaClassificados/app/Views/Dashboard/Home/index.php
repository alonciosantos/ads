
<?= $this->extend('Dashboard/Layout/main'); ?>

<?= $this->section('title')?>


<?php echo $title ?? '';?>

<?= $this->endsection()?>


<?= $this->section('styles')?>

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
                        <h3 class="widget-header"><?php echo lang( 'App.title_index'); ?></h3>
                        

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

<?= $this->endsection()?>





    











 