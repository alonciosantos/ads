<?= $this->extend('Web/Layout/main.php'); ?>

<?= $this->section('title') ?>


<?php echo $title ?? ''; ?>

<?= $this->endsection() ?>


<?= $this->section('styles') ?>

<?= $this->endsection() ?>


<?= $this->section('content') ?>

<!-- Envio para o template principal o conteudo dessa view-->

<!--===========================================
=            Popular deals section            =
============================================-->

<section class="popular-deals section bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2><?php echo $title ?? 'Conheça os nossos planos'; ?></h2>

                </div>
            </div>
        </div>

        <div class="row">

            <?php if (empty($plans)) : ?>

                <div class="col-md-12">

                    <div class="alert alert-info text-center ">No momento não a planos disponíveis...</div>

                </div>
            <?php else : ?>

                <?php foreach ($plans as $plan) : ?>


                    <!-- offer 01 -->
                    <div class="col-sm-12 col-lg-3">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->

                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="<?php echo route_to('choice', $plan->id); ?>"><?php echo $plan->name; ?></a></h4>
                                    <ul class="list-inline product-meta">

                                        <li class="list-inline-item">
                                            <?php if ($plan->is_highlighted) : ?>

                                                <p class="text-primary">A melhor opção</p>

                                            <?php endif; ?>
                                        </li>
                                        <hr>
                                        <li class="list-inline-item">
                                            <?php echo $plan->details(); ?>
                                        </li>
                                                <hr>
                                        <li class="list-inline-item">
                                            <span>Anúncios :</span>  <?php echo $plan->adverts(); ?>
                                        </li>
                                        
                                        <!--<li class="list-inline-item">
                                            <span>Imagem/Anúncio :</span>  <?php //if($plan->adverts ==10){ echo "3";}elseif($plan->adverts ==20){echo "5";}elseif($plan->adverts ==30){echo "8";}else{echo "Ilimitado";} ?>
                                        </li>-->

                                    </ul>
                                    <p class="card-text"><?php echo $plan->description;?></p>
                                    <div class="product-ratings">
                                       <!--  <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li> -->
                                        </ul>
                                    </div>
                                    <hr>
                                    <a href="<?php echo route_to('choice',$plan->id) ;?>" class="btn btn-main-sm mt-2"><?php echo lang('Plans.btn_choice') ;?></a>
                                </div>
                            </div>
                        </div>



                    </div>

                <?php endforeach; ?>

            <?php endif; ?>



        </div>
    </div>
</section>


<?= $this->endsection() ?>


<?= $this->section('scripts') ?>

<!-- Envio para o template principal os arquivos scripts dessa view-->

<?= $this->endsection() ?>