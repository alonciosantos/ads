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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="section-title">
                    <h2><?php echo $title ?? 'Anúncios Recentes'; ?></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, magnam.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (empty($adverts)) : ?>

                <div class="alert alert-info mx-auto">Não há anúncios cadastrados</div>

            <?php else : ?>

                <?php foreach ($adverts as $advert) : ?>
                    <!-- offer 01 -->
                    <div class="col-12 col-md-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content mx-auto d-block">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="<?php echo route_to('adverts.detail', $advert->code); ?>">
                                    <?php echo $advert->image(classImage: 'card-img-top', sizeImage: 'small'); ?>
                                </a>
                                </div>
                                <div class="card-body">
                                    
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-folder-open-o"></i>Electronics</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-title"><a href="<?php echo route_to('adverts.detail', $advert->code); ?>">
                                        <?php echo word_limiter($advert->title, '4'); ?>
                                    </a></p>
                                    <div class="product-ratings">
                                        <ul>
                                            <li class="card-text text-primary "> <strong><?php echo $advert->price(); ?></strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                <?php endforeach; ?>

                <div class="col-md-12 mt-4">
                    <?php echo $pager->links() ;?>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>


<?= $this->endsection() ?>


<?= $this->section('scripts') ?>

<!-- Envio para o template principal os arquivos scripts dessa view-->

<?= $this->endsection() ?>