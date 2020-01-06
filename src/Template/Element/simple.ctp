<div class="row">
    
    <?= $this->Form->create($pagina, ['class' => 'form-horizontal', 'data-parsley-validate' => '', 'type' => 'file' ]) ?>

    <div class="col-md-12">
        <h3>Datos visuales</h3>
        <input type="hidden" name="template" value="<?= $pagina->template ?>">
        <div class="form-group row">
            <label for="nombre" class="col-md-2 control-label">Nombre</label>
            <div class="col-md-10">
                <?php echo $this->Form->input('nombre', ['required' => true, 'class' => 'form-control', 'label' => false]); ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="slug" class="col-md-2 control-label">Slug</label>
            <div class="col-md-10">
                <?php echo $this->Form->input('slug', ['required' => true, 'class' => 'form-control', 'label' => false]); ?>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="contenido" class="col-md-2 control-label">Contenido</label>
            <div class="col-md-10">
                <?php echo $this->Form->textarea('contenido', ['class' => 'form-control contenido', 'label' => false]); ?>
            </div>
        </div>

        <div class="form-grou rowp">
            <label for="imagen" class="col-md-2 control-label">Imagen</label>
            <div class="col-md-10">
                <?php echo $this->Form->input('imagen', ['class' => 'form-control', 'label' => false, 'type' => 'file']); ?>
                <div id="vista_imagen" <?= (!empty($pagina->imagen))? 'style="display:block;"': 'style="display:none;"'; ?> >
                    <div class="divImagen" style="float:left; background:url(<?= (!empty($pagina->imagen))? $pagina->ruta_imagen: ''; ?>)no-repeat center center / contain; width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        
        <?= $this->element('Metas/metas') ?>

    </div>
    <div class="col-md-6">

        <?= $this->element('Metas/twitter') ?>
        
        <?= $this->element('Metas/opengraph') ?>
        
    </div>

    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <?= $this->Form->button(__('Guardar '), ["class" => "btn btn-primary pull-right"]) ?>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>

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
            content_css: [
                'https://www.drdieta.com.ar/css/publico.css'
            ],
            // without images_upload_url set, Upload tab won't show up
            images_upload_url: 'https://www.drdieta.com.ar/upimagen',

            // we override default upload handler to simulate successful upload
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', 'https://www.drdieta.com.ar/upimagen');

                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            }
        });

        $("#imagen").on('change', function(){
            $('#divImagen').css('display', 'block');
        });

        $.preImagen({
            input   : "#imagen",
            imgDiv  : ".divImagen",
            infDiv  : ".infoDiv"
        });           
    });

</script>
