<?php
    $imagen_banner = 'banner-bg.jpg';
?>

<!-- Banner superior -->
<section class="home_banner_area mb-40" style="background-image: url('<?= $this->Url->build(sprintf("/img/banner/%s", $imagen_banner), true) ?>');">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content row">
                <div class="col-lg-12">
                    <h3 class="text-center">Titulo completo</h3>
                    <h4 class="text-center">Descripcion</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner superior -->

<!-- Listado de productos ? -->
<section class="inspired_product_area section_gap_bottom_custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="main_title">
                    <h2 class="text-center"><span>Productos destacados</span></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($productos_destacados)) : 
                foreach ($productos_destacados as $producto) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-product">
                        <div class="product-img">
                            <?= $this->Html->image(
                                sprintf('products/%s', $producto['img1']), [
                                    'class' => 'img-fluid w-100'
                                ]
                            ) ?>
                        </div>
                        <br>
                        <div class="product-btm">
                            <?= $this->Html->link(
                            sprintf("<h4>%s</h4>", $producto['name']), 
                                [
                                    'controller' => 'Products',
                                    'action' => 'view', $producto['id']
                                ], [
                                    'escape' => false,
                                    'class' => 'd-block text-center'
                                ]
                            ) ?>
                            <div class="mt-3">
                                <h5 class="text-center"><?= $this->Number->currency($producto['price'], 'USD') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; 
            endif; ?>
        </div>
        <?= $this->Html->link(
        sprintf("<h3>%s</h3>", "Ver más productos"), 
            [
                'controller' => 'Products',
                'action' => 'index',
            ], [
                'escape' => false,
                'class' => 'd-block text-center'
            ]
        ) ?>
    </div>
</section>
<!-- Listado de productos ? -->

<hr>

<!-- Blog -->
<section class="blog-area section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="main_title">
                    <h2 class="text-center"><span>Blog</span></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($entradas)) : foreach ($entradas as $entrada) : ?>
            <div class="col-lg-4 col-md-6">
                <div class="single-blog">
                    <div class="thumb">
                        <?= $this->Html->image(
                                'posts/'.$entrada['img'], [
                                'class' => 'img-fluid'
                            ]
                        ); ?>
                    </div>
                    <br>
                    <div class="short_details">
                        <?= $this->Html->link(
                            sprintf("<h4>%s</h4>", $entrada['title']), [
                                'controller' => 'Posts',
                                'action' => 'view', $entrada['id']
                            ], [
                                'escape' => false,
                                'class' => 'd-block text-center'
                            ]
                        ) ?>
                        <div class="text-wrap">
                            <p><?= substr($entrada['text'],0,200); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<!-- Blog -->