<section class="cat_product_area section_gap">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <div class="latest_product_inner">
                    <div class="row">
                        <?php if (!empty($products)) : ?>
                            <?php foreach ($products as $producto) : ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <?php if (!empty($producto['img1'])) { ?>
                                                <?= $this->Html->image(
                                                    sprintf('products/%s', $producto['img1']),
                                                        [
                                                            'class' => 'card-img'
                                                        ]
                                                ) ?>
                                            <?php } else { ?>
                                                <?= $this->Html->image('default.png') ?>
                                            <?php } ?>
                                        </div>
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
                                            <br>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <?= $this->element('Admin/paginador') ?>
                </div>
            </div>
        </div>
    </div>
</section>