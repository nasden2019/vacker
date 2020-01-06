<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title">Agregar categoría</h4>
                
                <hr>
                <?= $this->Form->create($category, ['type' => 'file']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre de categoría</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <?= $this->Html->link(
                            'Cancelar',
                            [
                                'controller' => 'postCategories',
                                'action' => 'index'
                            ], [
                                'class' => 'btn btn-light'
                            ]
                        ) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>