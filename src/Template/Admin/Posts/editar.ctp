<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title">Editar Post</h4>
                
                <?= $this->Form->create($post, ['type' => 'file']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Título</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('title', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                                 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Descripcion</label>
                                <div class="col-sm-9">
                                    <?= $this->Form->input('text', ['class' => 'form-control', 'label' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="img" class="col-sm-3 col-form-label">Imagen Post</label>
                                <div class="col-sm-9">
                                <?= $this->Form->input('img', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php echo $this->Html->image('posts/'.$post->img, ['alt' => 'Logo']);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <?= $this->Html->link(
                            'Cancelar',
                            [
                                'controller' => 'posts',
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