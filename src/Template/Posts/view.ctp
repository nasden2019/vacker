<div class="product_image_area">
    <div class="container">
        <div class="col-lg-12">
            <div class="">
                <?= $this->Html->image('posts/'.$post->img, ['alt' => 'Logo']);?>
                <hr>
            </div>
            <div class="s_product_text">
                <h3><?php echo($post['title']); ?></h3>
                <p><?php echo($post['text']); ?></p>
            </div>
        </div>
    </div>
</div>
