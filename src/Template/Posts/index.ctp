<section class="cat_product_area section_gap">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <div class="latest_product_inner">
                    <div class="row">
                        
                        <?php if (!empty($posts)) : ?>
                            <?php foreach ($posts as $post) : ?>
                        
                                <div class="col-lg-12 col-md-12">
                                    <div class="single-product">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <?= $this->Html->image('posts/'.$post->img, ['alt' => 'Logo']);?>
                                            </div>
                                            <div class="col-lg-7">
                                                <h3>
                                                    <?= $post['title']; ?>
                                                </h3>
                                                <p>
                                                    <?php echo $post['text']; ?>
                                                </p>
                                            </div>
                                            <h5 class="col-md-2 ">
                                                <?php 
                                                    echo $this->Html->link(
                                                        '+ Ver más', 
                                                        ['action' => 'view', $post['id']]);
                                                ?>
                                            </h5>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                    </div>
                </div>
                <?= $this->element('Admin/paginador') ?>
            </div>
            <!--<div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Categorías</h3>
                        </div>
                        
                        <div class="widgets_inner">
                            <ul class="list">
                                <?php 
                                    $categorias = [
                                        0 => [
                                            'nombre' => 'Categoría 1',
                                            'cantidad' => '12',
                                            'link' => '#',
                                        ],
                                        1 => [
                                            'nombre' => 'Categoría 2',
                                            'cantidad' => '3',
                                            'link' => '#',
                                        ],
                                        2 => [
                                            'nombre' => 'Categoría 3',
                                            'cantidad' => '25',
                                            'link' => '#',
                                        ],
                                        3 => [
                                            'nombre' => 'Categoría 4',
                                            'cantidad' => '7',
                                            'link' => '#',
                                        ],
                                    ];
                                    foreach ($categorias as $categoria) :
                                ?>
                                <li>
                                    <a href="<?= $categoria['link'] ?>" class="d-flex">
                                        <p><?= $categoria['nombre'] ?></p>
                                        <p>(<?= $categoria['cantidad'] ?>)</p>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>-->
        </div>
    </div>
</section>