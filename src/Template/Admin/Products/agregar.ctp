<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title">Agregar Producto</h4>
                
                <hr>
                <?= $this->Form->create($product, ['type' => 'file']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Precio</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('price', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                                 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Descripcion</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('description', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-3 col-form-label">Imagen producto</label>
                                <div class="col-sm-9">
                                <?= $this->Form->input('img1', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-3 col-form-label">Imagen producto</label>
                                <div class="col-sm-9">
                                <?= $this->Form->input('img2', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-3 col-form-label">Imagen producto</label>
                                <div class="col-sm-9">
                                <?= $this->Form->input('img3', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-3 col-form-label">Imagen producto</label>
                                <div class="col-sm-9">
                                <?= $this->Form->input('img4', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <?= $this->Html->link(
                            'Cancelar',
                            [
                                'controller' => 'products',
                                'action' => 'index'
                            ], [
                                'class' => 'btn btn-light'
                            ]
                        ) ?>
                    </div>
                    
                <?= $this->Form->end() ?>

            </div>
    </div>
</div></div>