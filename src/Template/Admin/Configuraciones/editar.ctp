
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title"><i class="fa fa-users"></i> Editar configuración</h4>

                <?= $this->Form->create($info, ['class' => 'form-horizontal', 'data-parsley-validate' => '', 'type' => 'file' ]) ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="facebook" class="col-md-2 control-label">Facebook</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('facebook', ['required' => true, 'class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="instagram" class="col-md-2 control-label">Instagram</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('instagram', ['class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="youtube" class="col-md-2 control-label">Youtube</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('youtube', ['class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="telefono" class="col-md-2 control-label">Tel&eacute;fono</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('telefono', ['class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="email" class="col-md-2 control-label">Email</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('email', ['type' => 'email', 'class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="terminos_cond" class="col-md-2 control-label">T&eacute;rminos y Condiciones</label>
                            <div class="col-md-10">
                                <?php echo $this->Form->input('terminos_cond', ['type' => 'textarea',  'class' => 'form-control', 'label' => false]); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <?= $this->Form->button(__('Editar'), ["class" => "btn btn-success pull-right", "value" => 'editar']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea',
            height: 150,
            menubar: false,
            relative_urls: false,
            remove_script_host: false,
            plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help'
            ],
            toolbar: 'insert | undo redo |  styleselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image code help',
        });   
    });
</script>
