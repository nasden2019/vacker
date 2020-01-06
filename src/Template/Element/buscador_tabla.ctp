<?php $ancho = (!empty($ancho))? $ancho : ''; ?>
<div class="input-group input-group-sm" style="width: <?= $ancho ?>">
    <?php   
        echo $this->Form->create(null, ['class' => 'input-group', 'type' => 'get']);
        $this->Form->templates(['inputContainer' => '{{content}}']);
        echo $this->Form->input('search', ['class' => 'form-control pull-right', 'placeholder' => 'Buscar', 'label' => false, 'autocomplete' => 'off']);
    ?>
    <div class="input-group-btn">
    <?= $this->Form->button('<i class="fa fa-search"></i>', ['class' => 'btn btn-default', 'escape' => false]); ?>
    </div>
    <?= $this->Form->end(); ?>
</div>