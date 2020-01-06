<?php 

    $mensajes = [];
    $cant = 0;
    
?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <?= $this->Html->link(

            $this->Html->image( 'logo_syloper.png', [ 'alt' => 'Logo syloper' ] ),
            [
                'controller' => '/',
                'action' => 'dashboard'
            ],[
                'class' => 'navbar-brand brand-logo',
                'escape'=> false,
            ]
        ) ?>

        <?= $this->Html->link(

            $this->Html->image( '/favicon.png', [ 'alt' => 'Logo syloper reducido' ] ),
            [
                'controller' => '/',
                'action' => 'dashboard'
            ],[
                'class' => 'navbar-brand brand-logo-mini',
                'escape'=> false,
            ]
        ) ?>

    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">


        <?php $add = ['Usuarios', 'Products', 'Posts', 'PostCategories'] ?>

        
        <?php if (in_array($this->request['controller'], $add)): ?>
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
            <li class="nav-item">
                <?= $this->Html->link(__('<i class="mdi mdi-plus"></i> Nuevo'), ['action' => 'agregar'], ['class' => 'nav-link', 'escape' => false]) ?>
            </li>
        </ul>
        <?php
         else: ?>
        <!--ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-image-filter"></i>Galería</a>
            </li>
            <li class="nav-item active">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-email-outline"></i>Inbox</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-calendar"></i>Calendario</a>
            </li>
        </ul-->
        <?php endif ?>

        <ul class="navbar-nav navbar-nav-right">
            <!--li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell-ring"></i>
                    <span class="count">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <a class="dropdown-item">
                        <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                        </p>
                        <span class="badge badge-pill badge-warning float-right">View all</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="icon-info mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">Application Error</h6>
                            <p class="font-weight-light small-text">
                                Just now
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="icon-speech mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">Settings</h6>
                            <p class="font-weight-light small-text">
                                Private message
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="icon-envelope mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">New user registration</h6>
                            <p class="font-weight-light small-text">
                                2 days ago
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email-variant"></i>
                    <?php if((isset($mensajes)) AND ($cant > 0)): ?>
                    <span class="count">
                        <?=$cant?>
                    </span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <div class="dropdown-item">

                        <p class="mb-0 font-weight-normal float-left">
                            <?= sprintf('Tenés %s mensajes sin leer',$cant)?>
                        </p>
                        <span class="badge badge-info badge-pill float-right">Ver todos</span>
                    </div>
                    <?php foreach($mensajes as $msj): ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <?= $this->Html->image(
                                'faces/face4.jpg',
                                [
                                    'class' => 'profile-pic',
                                ]
                            ) ?>
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-medium">
                                <?= $msj->nombre?>
                            </h6>
                            <p class="font-weight-light small-text">
                                <?= $msj->asunto?>
                            </p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </li-->
            <li class="nav-item d-none d-lg-block">
                <?= $this->Html->link(
                    $this->Html->image('perfiles/'.$userLogin['imagen'], ['alt' => $userLogin['nombre'],'width' => '100%','class' => 'img-xs rounded-circle' ]),
                    [
                        'controller' => '/',
                        'action' => 'perfil'
                    ],[
                        'class' => 'nav-link',
                        'escape'=> false,
                    ]
                ) ?>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>