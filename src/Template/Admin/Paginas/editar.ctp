<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar pagina</h4>
                <small><?= $pagina->nombre ?></small>
                <br>
                <?= $this->Form->create($pagina, ['class' => 'form-horizontal', 'data-parsley-validate' => '', 'type' => 'file' ]) ?>

                    <div class="row">
                        
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
                            
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">HTML Metas</h4>
                                </div>

                                <?php 
                                    $comunes = ["description", "url", "language", "robots"];
                                ?>

                                <?php $i=19; foreach ($comunes as $clave): ?>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 control-label"><?= $clave ?></label>
                                        <div class="col-sm-9">
                                            <?php $valor = !empty($metas[$clave]) ? $metas[$clave] : "" ; ?>
                                            <?php echo $this->Form->input(sprintf('meta.%s.name', $i), ['value'=> $clave, 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                            <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor]); ?>
                                        </div>
                                    </div>
                                <?php $i++; endforeach; ?>
                                    
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?php 
                                $lista = ["twitter:card", "twitter:url", "twitter:title", "twitter:description", "twitter:site", "twitter:creator", "twitter:image"];
                            ?>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Twitter</h4>
                                    
                                    <?php $i = 10; foreach ($lista as $clave): ?>

                                        <?php if ($clave !== 'twitter:image'): ?>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 control-label"><?= $clave ?></label>
                                            <div class="col-sm-8">
                                                <?php $valor = !empty($metas[$clave]) ? $metas[$clave] : "" ; ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.name', $i), ['value'=> $clave, 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor]); ?>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label">twitter:image</label>
                                            <?php $valor = !empty($metas["twitter:image"]) ? $metas["twitter:image"] : "" ; ?>
                                            <div class="col-sm-4">
                                                <?php echo $this->Form->input(sprintf('meta.%s.name', $i), ['value'=> $clave, 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor]); ?>
                                            </div>

                                            <?php $i++; ?>

                                            <?php $valor = !empty($metas["twitter:image:width"]) ? $metas["twitter:image:width"] : "" ; ?>
                                            <div class="col-sm-3">
                                                <?php echo $this->Form->input(sprintf('meta.%s.name', $i), ['value'=> sprintf("%s:width", $clave), 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor, 'placeholder' => 'Ancho']); ?>
                                            </div>

                                            <?php $i++; ?>
                                            
                                            <?php $valor = !empty($metas["twitter:image:height"]) ? $metas["twitter:image:height"] : "" ; ?>
                                            <div class="col-sm-3">
                                                <?php echo $this->Form->input(sprintf('meta.%s.name', $i), ['value' => sprintf("%s:height", $clave), 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor, 'placeholder' => 'Alto']); ?>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    <?php $i++; endforeach ?>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            
                            <?php 
                                $lista = ["og:title", "og:type", "og:url", "og:description", "og:determiner", "og:locale", "og:site_name", "og:image"];
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Open Graph</h4>

                                    <?php $i = 0; foreach ($lista as $clave): ?>

                                        <?php if ($clave !== 'og:image'): ?>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 control-label"><?= $clave ?></label>
                                            <div class="col-sm-10">
                                                <?php $valor = !empty($metas[$clave]) ? $metas[$clave] : "" ; ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.property', $i), ['value'=> $clave, 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor]); ?>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="form-group row">
                                            
                                            <?php $valor = !empty($metas["og:image"]) ? $metas["og:image"] : "" ; ?>
                                            <label for="" class="col-sm-2 control-label">og:image</label>
                                            <div class="col-sm-4">
                                                <?php echo $this->Form->input(sprintf('meta.%s.property', $i), ['value'=> $clave, 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor]); ?>
                                            </div>

                                            <?php $i++; ?>

                                            <?php $valor = !empty($metas["og:image:width"]) ? $metas["og:image:width"] : "" ; ?>
                                            <div class="col-sm-3">
                                                <?php echo $this->Form->input(sprintf('meta.%s.property', $i), ['value'=> sprintf("%s:width", $clave), 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor, 'placeholder' => 'Ancho']); ?>
                                            </div>

                                            <?php $i++; ?>
                                            
                                            <?php $valor = !empty($metas["og:image:height"]) ? $metas["og:image:height"] : "" ; ?>
                                            <div class="col-sm-3">
                                                <?php echo $this->Form->input(sprintf('meta.%s.property', $i), ['value'=> sprintf("%s:height", $clave), 'type'=>'hidden', 'class' => 'form-control', 'label' => false]); ?>
                                                <?php echo $this->Form->input(sprintf('meta.%s.content', $i),  ['class' => 'form-control', 'label' => false, 'value' => $valor, 'placeholder' => 'Alto']); ?>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    <?php $i++; endforeach ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <?= $this->Form->button(__('Guardar '), ["class" => "btn btn-primary pull-right"]) ?>
                                </div>
                            </div>
                        </div>

                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

    	var titulo = "<?= (!empty($this->request->data['nombre']))? $this->request->data['nombre'] : ((!empty($pagina['nombre']))? $pagina['nombre'] : ''); ?>";
        var slug = "<?= (!empty($this->request->data['slug']))? $this->request->data['slug'] : ((!empty($pagina['slug']))? $pagina['slug'] : ''); ?>";
        var controlador = "<?= $this->request['controller'] ?>";

        $("#meta-20-content").val("es-ar");
        $("#meta-5-content").val("es-ar");

        // console.log(slug);
        if(slug != ''){
            $("#meta-20-content").val("https://www.drdieta.com.ar/"+slug);
            $("#meta-11-content").val("https://www.drdieta.com.ar/"+slug);
            $("#meta-2-content").val("https://www.drdieta.com.ar/"+slug);
        }
        if(titulo != ''){
        	// $("#meta-20-content").val(titulo + " | DrDieta");
            $("#meta-12-content").val(titulo + " | DrDieta");
            $("#meta-0-content").val(titulo + " | DrDieta");
        }

        $("#nombre").change(function(){
            var titulo = $(this).val();
            $("#slug").attr("disabled", true).parent().append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            // TITULOS
            $("#meta-20-content").val(titulo + " | DrDieta");
            $("#meta-12-content").val(titulo + " | DrDieta");
            $("#meta-0-content").val(titulo + " | DrDieta");
            

            $.ajax({
                type:'POST',
                url: host+"paginas/getSlug",
                data:{titulo, controlador},
                dataType: "json",
                success:function(data){
                    if(data.estado){
                        // URLs
                        slug = data.slug
                        $("#slug").val(data.slug);
                        $("#meta-20-content").val("https://www.drdieta.com.ar/"+data.slug);
                        $("#meta-11-content").val("https://www.drdieta.com.ar/"+data.slug);
                        $("#meta-2-content").val("https://www.drdieta.com.ar/"+data.slug);
                    }else{
                        alert(data.mensaje);
                    }
                    $("#slug").attr("disabled", false).parent().find(".overlay").remove();
                },
                error: function(data){
                    console.error(data);
                }
            });
        });

        $("#descripcion-corta").change(function(){
            // DESCRIPCION
            $("#meta-20-content").val($(this).val());
            $("#meta-13-content").val($(this).val());
            $("#meta-3-content").val($(this).val());

        });

        $("#slug").change(function(){
            var titulo = $(this).val();
            $("#slug").attr("disabled", true).parent().append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

            $.ajax({
                type:'POST',
                url: host+"paginas/getSlug",
                data:{titulo, controlador},
                dataType: "json",
                success:function(data){
                    if(data.estado){
                        // URLs
                        if(data.existe){
                            var r = confirm("El slug ya existe! Recomendamos: '"+ data.slug+"' ¿Desea cambiarlo?");
                            if(r){
                                slug = data.slug;
                                $("#slug").val(data.slug);
                                $("#meta-20-content").val("https://www.drdieta.com.ar/"+data.slug);
                                $("#meta-11-content").val("https://www.drdieta.com.ar/"+data.slug);
                                $("#meta-2-content").val("https://www.drdieta.com.ar/"+data.slug);
                            }else{
                                $("#slug").val(slug);
                            }
                        }else{
                            $("#slug").val(data.slug);
                            $("#meta-20-content").val("https://www.drdieta.com.ar/"+data.slug);
                            $("#meta-11-content").val("https://www.drdieta.com.ar/"+data.slug);
                            $("#meta-2-content").val("https://www.drdieta.com.ar/"+data.slug);
                        }
                    }else{
                        alert(data.mensaje);
                    }
                    $("#slug").attr("disabled", false).parent().find(".overlay").remove();
                },
                error: function(data){
                    console.error(data);
                }
            });
        });
    });
</script>