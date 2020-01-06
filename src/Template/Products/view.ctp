<!--================Single Product Area =================-->
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_product_img">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                            </li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1">
                            </li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2">
                            </li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3">
                            </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <?php if (!empty($product['img1'])) { ?>
                                    <?php echo $this->Html->image('products/'.$product['img1'], ['alt' => 'Logo']); ?>
                                <?php } else { ?>
                                    <?php echo $this->Html->image('default.png', ['alt' => 'Imagen del Producto']); ?>
                                <?php } ?>
                            </div>
                            <div class="carousel-item">
                                <?php if (!empty($product['img2'])) { ?>
                                    <?php echo $this->Html->image('products/'.$product['img2'], ['alt' => 'Logo']); ?>
                                <?php } else { ?>
                                    <?php echo $this->Html->image('default.png', ['alt' => 'Imagen del Producto']); ?>
                                <?php } ?>
                            </div>
                            <div class="carousel-item">
                                <?php if (!empty($product['img3'])) { ?>
                                    <?php echo $this->Html->image('products/'.$product['img3'], ['alt' => 'Logo']); ?>
                                <?php } else { ?>
                                    <?php echo $this->Html->image('default.png', ['alt' => 'Imagen del Producto']); ?>
                                <?php } ?>
                            </div>
                            <div class="carousel-item">
                                <?php if (!empty($product['img4'])) { ?>
                                    <?php echo $this->Html->image('products/'.$product['img4'], ['alt' => 'Logo']); ?>
                                <?php } else { ?>
                                    <?php echo $this->Html->image('default.png', ['alt' => 'Imagen del Producto']); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo($product['name']); ?></h3>
                    <h2><?php echo($product['price']); ?></h2>
                </div>
            </div>
        </div>
        <hr>
        <br>
    </div>
</div>
<!--================End Single Product Area =================-->

<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Description</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <p>
                    <?php echo($product['description']); ?>
                </p>
            </div>
        </div>
    </div>
</section>