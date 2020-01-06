<!DOCTYPE html>
<html lang="es">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Base">
        <meta name="author" content="Syloper">

        <title>
            <?= (!empty($titulo)) ? $titulo : "Base" ?>
        </title>

        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css(
            [
                'base.css',
                "bootstrap.min.css",
                'cake.css',
                'style.css',
                "/vendor/select2/select2.min.css",
                "/vendor/select2/select2-bootstrap4.min.css",
                "/vendor/iziToast/iziToast.min.css",
                "main.min.css"
            ]) 
        ?>

    </head>

    <body>
        <nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-3 medium-4 columns">
                <li class="name">
                    <h1><?= $this->Html->link('Home',['controller'=>'Paginas', 'action' => 'home'],['escape' => false]); ?></h1>
                </li>
            </ul>
            <div class="top-bar-section">
                <ul class="right">
                    <?php if(!empty($userLogin)) {
                        //if($userLogin['rol'] == 'usuario') { ?>
                            <li><h6 style="color: #ffffff; margin-bottom: 0; padding-top: 13px; margin-right: 10px; font-size: 0.8125rem;">Bienvenido, <?php echo $userLogin['nombre']; ?></h6></li>
                            <li><?= $this->Html->link(__('Cerrar Sesion'), ['controller' => 'Usuarios' ,'action' => 'logout'], ['confirm' => __('¿Esta seguro?')]) ?></li>
                        <?php //}
                    } else { ?>
                        <li><a href="<?=HOST?>registro">Registrarme</a></li>
                        <li><a href="<?=HOST?>login">Ingresar</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        
        <div class="container clearfix">        
            <?= $this->fetch('content') ?>
        </div>
    
        <?= $this->Html->script(
            [
                "jquery-3.2.1.min.js",
                "bootstrap.min.js",
                "popper.min.js",
                "/vendor/select2/select2.full.min.js",
                "/vendor/tinymce/tinymce.min.js",
                "/vendor/iziToast/iziToast.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.min.js"
            ]) 
        ?>
        
        <?php $this->Flash->render() ?> 
        

    </body>
</html>