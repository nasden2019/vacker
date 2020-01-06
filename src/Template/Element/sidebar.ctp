 <!-- Sidebar -->
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>
        <li><?= $this->Html->link(__('Inicio'), ['controller' => 'Usuarios' ,'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Cerrar Sesion'), ['controller' => 'Usuarios' ,'action' => 'logout'], ['confirm' => __('¿Esta seguro?')]) ?></li>
    </ul>
</nav>