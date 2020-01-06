<!DOCTYPE html>
<html lang="es">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="application-name" content="<?= (!empty($datos['titulo']))? $datos['titulo'] : 'Base' ?>">
        <meta name="description" content="<?= (!empty($datos['descripcion']))? $datos['descripcion'] : 'Base' ?>">
        <meta name="author" content="Syloper">
        <title>
            <?= (!empty($titulo))? sprintf("%s | Team", $titulo) : ((!empty($datos['titulo']))? $datos['titulo'] : 'Base') ?>
        </title>

        <?= $this->fetch('meta') ?>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css([
            '/vendor/mdi/css/materialdesignicons.min.css',
            '/vendor/simple-line-icons/css/simple-line-icons.css',
            'star.css'
        ]) ?>

    </head>

    <body>
        
        <?= $this->fetch('content') ?>   

        <?= $this->Html->script([
            "jquery-3.2.1.min.js",
            "popper.min.js",
            "bootstrap.min.js",
            "off-canvas.js",
            "misc.js"
        ]) ?>


    </body>
</html>