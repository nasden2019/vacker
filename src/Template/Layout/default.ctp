<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="application-name" content="FoodAPP">
        <meta name="description" content="FoodAPP">
        <meta name="author" content="Syloper">
        <title>Security 24</title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>

        <script type="text/javascript">
            if(window.location.hostname == 'localhost'){  var host = '/FoodAPP/'; }else{ var host = '/'; };
        </script>
    </head>
    <body>
        
        <?= $this->Flash->render() ?>
            
        <?= $this->fetch('content') ?>
    </body>
</html>
