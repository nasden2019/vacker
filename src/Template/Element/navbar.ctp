<!-- NavBar -->
<nav class="top-bar expanded" data-topbar role="navigation">
    <ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href="/"><?= (!empty($datos['titulo']))? $datos['titulo'] : 'TeamSyloper' ?></a></h1>
        </li>
    </ul>
    <div class="top-bar-section">
        <ul class="right">
            <!--<li><a target="_blank" href="https://book.cakephp.org/3.0/">Documentation</a></li>
            <li><a target="_blank" href="https://api.cakephp.org/3.0/">API</a></li>-->
            <li><a href="/usuarios/perfil">Mi Perfil</a></li>
        </ul>
    </div>
</nav>