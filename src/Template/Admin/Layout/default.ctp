<!DOCTYPE html>
<html lang="en">

    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="application-name" content="Base">
        <meta name="description" content="Base">
        <meta name="author" content="Syloper">
        <title>Base</title>
        
        <?= $this->fetch('meta') ?>
        <?= $this->Html->meta('icon') ?>
            
        <?= $this->Html->css([
            '/vendor/mdi/css/materialdesignicons.min.css',
            'datapicker.css',
            '/vendor/simple-line-icons/css/simple-line-icons.css',
            '/vendor/select2/select2.min.css',
            'star.css',
            '/webroot/vendor/iziToast/iziToast.min.css'
        ]) ?>
        <script type="text/javascript">
            if(window.location.hostname == 'localhost'){  var host = '/base/'; }else{ var host = '/'; };
        </script>
    </head>

    <body>
        <div class="container-scroller">

            <?= $this->element('Admin/navbar') ?>
            
            <div class="container-fluid page-body-wrapper">
                
                <?= $this->element('Admin/sidebar') ?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <?= $this->fetch('content') ?>
                    </div>
                    <?= $this->element('Admin/footer') ?>
                </div>
                
            </div>

        </div>
      
        <?= $this->Html->script([
            "jquery-3.2.1.min.js",
            "datapicker.js",
            "/vendor/tinymce/tinymce.min.js",
            "/vendor/select2/select2.min.js",
            "popper.min.js",
            "bootstrap.min.js",
            "off-canvas.js",
            "misc.js",
            "/webroot/vendor/iziToast/iziToast.min.js"
        ]) ?>

        <script>
            $( function() {
                $( ".fechas" ).datepicker({
                format: "DD-MM-YYYY",
                locale: 'es',
              });
            } );
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <script>
            tinymce.init({ 
                selector: 'textarea',
                setup: function (editor) {
                    editor.on('change', function (e) {
                        editor.save();
                    });
                }
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){

                $('#empresas').on('change',function(event){
                    var id = $('#empresas').val();
                    event.preventDefault();

                    $.ajax({
                        type: 'GET',
                        url: "<?=HOST?>admin/locales/getLocales/"+id,
                        dataType: "json",
                        success: function (data) {
                            if (data.estado){                        
                                var select = $('#local');
                                select.empty().attr('disabled',false);
                                var opciones = [
                                    "<option value=''>Seleccione Local</option>"
                                ];
                                for(var id in data.locales){
                                    opciones += "<option value=" +parseInt(id)+ ">" +data.locales[id]+ "</option>";
                                }                        
                                select.html(opciones);
                            }
                        }
                    })
                })

                $('#local').on('change',function(event){
                    var id = $('#local').val();
                    event.preventDefault();

                    $.ajax({
                        type: 'GET',
                        url: "<?=HOST?>admin/categorias/getCategorias/"+id,
                        dataType: "json",
                        success: function (data) {
                            if (data.estado){                        
                                var select = $('#categoria');
                                select.empty().attr('disabled',false);
                                var opciones = [
                                "<option value=''>Seleccione Categoria</option>"
                                ];
                                for(var id in data.categoria){
                                    opciones += "<option value=" +parseInt(id)+ ">" +data.categoria[id]+ "</option>";
                                }                        
                                select.html(opciones);
                            }
                        }
                    })
                })
            })
        </script>
        <script type="text/javascript">
            var tabcontent = $('.nav-item'), 
                tablinks = $('.nav-link');

            if (tabcontent.length && tablinks.length) {
                tablinks.on('click', function (e) {

                   // var id = $(this).data('tab');
                    
                    $('.nav-item.active').removeClass('active');
                    //$('#' + id).addClass('active');

                    $('.nav-link.active').removeClass('active');
                    $(this).addClass('active');
                });
            } 
        </script>

        <script>
            $(".limpiar_filtro").on("click", function (e) {
                   e.preventDefault();
                   $("#formulario_filtro")[0].reset();
                   $("#formulario_filtro").closest('form').find("input[type=text], textarea").val("");
                   $(".select2").select2().val('').trigger("change");
                   $(".fechas").val('');
                   $("#formulario_filtro").submit();
            });
        </script>

        <?= $this->Flash->render() ?>
    </body>
</html>