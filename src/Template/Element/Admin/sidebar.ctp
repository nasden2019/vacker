<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                        <?= $this->Html->image('perfiles/'.$userLogin['imagen'], ['alt' => $userLogin['nombre'],'width' => '100%']);?>
                    <span class="online-status online"></span>
                </div>
                <div class="profile-name">
                    <p class="name">
                        <?= sprintf("%s %s", $userLogin['nombre'], $userLogin['apellido']) ?>
                    </p>
                    <p class="designation">
                        <?= ucfirst($userLogin['rol']) ?>
                    </p>
                    <div class="badge badge-teal mx-auto mt-3">Online</div>
                </div>
            </div>
        </li> <!-- Datos Login -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-television"></i><span class="menu-title">Dashboard</span>',
                [
                    'controller' => '/',
                    'action' => 'dashboard'
                ],[
                    'escape' => false,
                    'class' => 'nav-link'
                ]
            ) ?>
        </li> <!-- Dashboard -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-account"></i> <span class="menu-title">Usuarios</span> <i class="menu-arrow"></i>',
                "#sidebar-usuarios", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-pages"
                ]
            ) ?>

            <div class="collapse" id="sidebar-usuarios">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'Usuarios',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Agregar',
                            [
                                'controller' => 'Usuarios',
                                'action' => 'agregar'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Usuarios -->
        
        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-image-filter-none"></i><span class="menu-title">Paginas</span>',
                [
                    'controller' => 'Paginas',
                    'action' => 'index'
                ],[
                    'escape' => false,
                    'class' => 'nav-link'
                ]
            ) ?>
        </li> <!-- Páginas -->
        
        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-settings"></i><span class="menu-title">Configuraciones</span>',
                [
                    'controller' => 'Configuraciones',
                    'action' => 'editar'
                ],[
                    'escape' => false,
                    'class' => 'nav-link'
                ]
            ) ?>
        </li> <!-- Configuraciones -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-cash-multiple"></i> <span class="menu-title">Pagos</span> <i class="menu-arrow"></i>',
                "#sidebar-pagos", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-pagos"
                ]
            ) ?>

            <div class="collapse" id="sidebar-pagos">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'Pagos',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Registrar Pago',
                            [
                                'controller' => 'Pagos',
                                'action' => 'agregar'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Pagos -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-package-variant"></i> <span class="menu-title">Productos</span> <i class="menu-arrow"></i>',
                "#sidebar-productos", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-pages"
                ]
            ) ?>

            <div class="collapse" id="sidebar-productos">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'Products',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Agregar',
                            [
                                'controller' => 'Products',
                                'action' => 'agregar'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Productos -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-lead-pencil"></i> <span class="menu-title">Post</span> <i class="menu-arrow"></i>',
                "#sidebar-posts", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-pages"
                ]
            ) ?>

            <div class="collapse" id="sidebar-posts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'Posts',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Agregar',
                            [
                                'controller' => 'Posts',
                                'action' => 'agregar'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Posts -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-pencil-lock"></i> <span class="menu-title">Posts categorias</span> <i class="menu-arrow"></i>',
                "#sidebar-postcategories", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-pages"
                ]
            ) ?>

            <div class="collapse" id="sidebar-postcategories">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'PostCategories',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Agregar',
                            [
                                'controller' => 'PostCategories',
                                'action' => 'agregar'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Posts Categorias -->

        <hr>

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-cloud-download"></i> <span class="menu-title">Descargar Backup</span>',
                [
                    'controller' => 'Backup',
                    'action' => 'descargar'
                ],
                [
                    'escape' => false,
                    'class' => 'nav-link',
                ]
            ) ?>
        </li> <!-- Descargar backup -->

        <li class="nav-item">
            <?= $this->Html->link(
                '<i class="menu-icon mdi mdi-alert-circle-outline"></i> <span class="menu-title">Logs</span> <i class="menu-arrow"></i>',
                "#sidebar-logs", 
                [
                    'escape' => false,
                    'class' => 'nav-link',
                    'data-toggle' => 'collapse',
                    'aria-expanded' => "false",
                    'aria-controls' => "general-logs"
                ]
            ) ?>

            <div class="collapse" id="sidebar-logs">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            'Lista',
                            [
                                'controller' => 'Logs',
                                'action' => 'index'
                            ],[
                                'class' => 'nav-link'
                            ]
                        ) ?>
                    </li>
                </ul>
            </div>
        </li> <!-- Menu Logs -->

        <li class="nav-item purchase-button">
            <?= $this->Html->link(__('Cerrar Sesión'), ['controller' => 'Usuarios' ,'action' => 'logout'], ['class' => 'nav-link', 'confirm' => __('¿Esta seguro?')]) ?>
        </li>

    </ul>
</nav>