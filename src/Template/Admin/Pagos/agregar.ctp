<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h4 class="card-title"><i class='mdi mdi-cash-multiple'></i>  Registrar Pago</h4>

                <?= $this->Form->create($pago) ?>
                    <input type="hidden" name="status" value="Carga Manual admin: (<?= $user->email ?>)">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <?= $this->Form->input('monto', ['type' => 'number','class' => 'form-control', 'label' => false, 'placeholder' => 'Monto', 'title' => 'Monto', 'step' => '0.01','required' => true]);  ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= $this->Form->input('origen', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Origen', 'title' => 'Origen', 'options' => $mediosPago]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->input('usuario_id', ['class' => 'form-control select2', 'options' => $participantes, 'empty' => 'Seleccione Usuario', 'label' => false,'required' => true]); ?>
                        </div>

                        <div class="form-group col-md-12"><hr></div>

                        <div class="form-group col-md-6">
                            <h4 class="box-title">Sumar días al Vencimiento de la Licencia</h4>
                            <?= $this->Form->input('dias', ['class' => 'form-control select2', 'options' => ['7' => '+7 días','30' => '+30 días','60' => '+60 días','90' => '+90 días'], 'empty' => 'Seleccione', 'label' => false,'empty' => true]); ?>
                        </div>

                        <div class="form-group col-md-12"><hr></div>

                        <div class="form-group col-md-12">
                            <h4 class="box-title">Comentarios</h4>
                            <hr>
                            <?= $this->Form->textarea('datos', ['class' => 'form-control descripcion', 'label' => false]); ?>
                        </div>

                    </div>

                    <div class="row">
                        <!-- <a href="#" class="btn btn-default btn-md pull-left agregar"><i class="fa fa-plus"> Alimentos</i></a> -->
                        <?= $this->Form->button(__('Guardar'), ["class" => "btn btn-primary pull-right"]) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
