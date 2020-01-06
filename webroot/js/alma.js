if (typeof jQuery === "undefined") {
    throw new Error("ALMA necesita jQuery");
}

"use strict";

$.ALMA = {};
$.ALMA.opciones = {
    debug: true,
    local: '/alma/'
};

if (typeof SyloperOpciones !== "undefined") {
    $.extend(true, $.ALMA.opciones, ALMAOpciones);
}

var o = $.ALMA.opciones;

// Constructor
_iniciar();


// Apenas se inicia todo


// Cuando el sitio se cargo por completo
$(window).on("load", function () {

    $.ALMA.select2.iniciar();
    $.ALMA.cajas.iniciar();
    $.ALMA.buscador.iniciar();
    $.ALMA.publicar.iniciar();

});


// Cuando scrolleamos
$(window).on("scroll", function () {
});


// Cuando cambiamos el tamano del navegador
$(window).on("resize", function () {
});


// Constructor
function _iniciar() {

    'use strict';

    /**
     * 
     */
    $.ALMA.select2 = {
        iniciar: function () {
            if ($('.select2').length) {
                $('#modalHistoria').on('shown.bs.modal', function (e) {
                    $('.select2').each(function (i, e) {
                        var ph = $(this).data('placeholder');
                        $(e).select2({ 
                            dropdownParent: "#modalHistoria",
                            placeholder: ph,
                            allowClear: true,
                            theme: "bootstrap4",
                            language: "es"
                        });
                    });
                });
            }
        }
    };

    /**
     * 
     */
    $.ALMA.cajas = {
        ultimoID: false,
        
        /* primero: true,
        hayMas: true, */
        
        iniciar: function (){

            /* if ($.ADIP.media.config.primero) {
                $.ADIP.media.config.primero = false;
                // Consultas al llegar al tope de pagina
                $.ADIP.media.infinito();
            } */
            
            var _this = this;
            
            setTimeout(() => {
                $('#contenedor-sitio').addClass('loaded');
            }, 800);
    
            $('.avanzar').on('click', function (e) {
                e.preventDefault();

                var cat = $(this).data('categoria') || 1;
                $('#select-categoria').val(cat);

                $('.caja.activa').removeClass('activa');
                $(this).closest('.caja')
                    .addClass('completa')
                    .next()
                    .removeClass('oculta')
                    .addClass('activa');

                var resultado = $.ALMA.buscador._buscar(
                    'POST', 
                    'api/getHistorias',
                    {
                        categoria: cat || false,
                        relacion: $('#select-relacion').val() || false,
                        etapa: $('#select-etapa').val() || false,
                    }
                );

                //_d(resultado);
                if (resultado.estado && resultado.datos.length) {
                    // Crear cajas
                    _this._crearCajas({datos: resultado.datos});
                    
                    /* for (let i = 0; i < resultado.datos.length; i++) {
                        const tarjeta = resultado.datos[i];
                        if (i == (resultado.datos.length -1)) {
                            _this.ultimoID = tarjeta.id;
                        } else {
                            if (_this.ultimoID) {
                                _this.hayMas = false; 
                            } else {
                                // render vacio ?
                            }
                        }
                    }
                    
                    _this.infinito(); */
                    //$('main').addClass('encontrados');
                }
            });
    
            $('.retroceder').on('click', function (e) {
                e.preventDefault();
                $('.caja.activa').removeClass('activa').addClass('oculta');
                $(this).closest('.caja')
                    .removeClass('completa')
                    .addClass('activa');
                
                $('#render-tarjetas').html('');
                _this._quitar($(this).closest('.caja'));
            });

            $('#btn-buscar-historia').on('click', function (e) {
                e.preventDefault();
                $('#render-tarjetas').html('');
                let resultado = $.ALMA.buscador._buscar(
                    'POST', 
                    'api/getHistorias',
                    {
                        categoria: $('#select-categoria').val() || false,
                        relacion: $('#select-relacion').val() || false,
                        etapa: $('#select-etapa').val() || false,
                    }
                );

                if (resultado.estado && resultado.datos.length) {
                    _this._crearCajas({datos: resultado.datos});
                }
            });
        },
        _quitar: function(elemento) {
            var _this = this;
            if (elemento.next('.caja').length) {
                elemento.next('.caja')
                    .removeClass('activa completa')
                    .addClass('oculta');
                _this._quitar(elemento.next('.caja'));
            }
        },
        _crearCajas: function (datos, alFinal) {
            var source = $("#template-tarjeta").html();
            var template = Handlebars.compile(source);
            var result = template(datos);
            if (alFinal) {
                $('#render-tarjetas').append(result);
            } else {
                $('#render-tarjetas').html(result);
            }
            $('main').addClass('encontrados');
        },
        /* infinito: function () {
            var _this = this;
            // Chequear en cada scroll, cuando el div hizo tope y volver a llamar
            // al buscador
            _this._infinitio();
            
            _d('scroll');
            $('.encontrados').on('scroll', function () {
                _this._infinitio();
            })
        },
        _infinitio: function () {
            var _this = this;
            if (($('.encontrados').scrollTop() + $('.encontrados').innerHeight() >= $('.encontrados').scrollHeight) && _this.hayMas) {
                _d('haymas');
                let resultado = $.ALMA.buscador._buscar(
                    'POST', 
                    'api/getHistorias', 
                    {ultimoID : _this.ultimoID}
                );

                if (resultado.estado) {
                    _this._crearCajas({datos: resultado.datos}, true);
                }
            }
        } */
    };

    /**
     * 
     */
    $.ALMA.buscador = {
        buscando: false,
        iniciar: function(){
            var _this = this;

            //$('#mapa.avanzar').on('click', )

        },
        _buscar: function (metodo, url, data) {
            var _this = this,
                devolver = false;

            _this.buscando = true;
            // _this._spinner();

            $.ajax({
                type: metodo || 'GET',
                url: o.local + url,
                data: data || '',
                async: false, 
                dataType: "json",
                success: function (data) {
                    devolver = data;
                },
                error: function (data) {
                    _d('AJAX error');
                },
                complete: function (data) {
                    _this.buscando = false;
                }
            });
            
            return devolver;

        },
    };

    /**
     * 
     */
    $.ALMA.publicar = {
        iniciar: function () {
            var _this = this;
            
            $('#form-nueva-historia').on('submit', function (e) {
                
                e.preventDefault();

                let form = $(this),
                    serializado = form.serialize(),
                    resultado = $.ALMA.buscador._buscar(
                        'POST', 
                        'api/setHistoria',
                        serializado
                    );

                if (resultado.estado) {
                    iziToast.success({
                        timeout: 20000,
                        position: 'bottomRight',
                        title: 'Genial :',
                        message: resultado.mensaje,
                    });
                    $('#modalHistoria').modal('hide');
                    form.trigger('reset');
                } else {
                    iziToast.error({
                        timeout: 20000,
                        position: 'bottomRight',
                        title: 'Ups :',
                        message: resultado.mensaje,
                    });
                    // $('#modalHistoria').modal('hide');
                }
            });
        }
    };

};

// Funcion para loguear
function _d(d, v) {
    if ($.ALMA.opciones.debug) {
        m = d;
        if (v || v == 0 || v == false) {
            m = m + " : " + v;
        }
        console.log(m);
    }
}
