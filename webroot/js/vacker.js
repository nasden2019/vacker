if (typeof jQuery === "undefined") {
    throw new Error("Vacker necesita jQuery");
}

$.Vacker = {};
$.Vacker.opciones = {
    debug: true,
    local: '/vacker/'
};

if (typeof SyloperOpciones !== "undefined") {
    $.extend(true, $.Vacker.opciones, VackerOpciones);
}

var o = $.Vacker.opciones;

// Constructor
_iniciar();


// Apenas se inicia todo
$.Vacker.menu.iniciar();

// Cuando el sitio se cargo por completo
$(window).on("load", function () {

    $.Vacker.select2.iniciar();

});


// Cuando scrolleamos
$(window).on("scroll", function () {

});


// Cuando cambiamos el tamano del navegador
$(window).on("resize", function () {

});


// Constructor
function _iniciar() {

    /**
     * 
     */
    $.Vacker.select2 = {
        iniciar: function () {
            if ($('.select2').length) {
                
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
            
            }
        }
    };
    
    /**
     * 
     */
    $.Vacker.menu = {
        menu: null,
        activo: false,
        iniciar: function () {
            let _this = this;
            if ($('#menu-superior').length) {

                _this.menu = $('#menu-superior');

                $('#abrir-menu')
                    .off('click')
                    .on('click', function (e) {
                        e.preventDefault();
                        _d('click')
                        _this._abrirMenuResponsivo();
                    });
                    
                $('#cerrar-menu')
                    .off('click')
                    .on('click', function (e) {
                        _d('click')
                        e.preventDefault();
                        _this._cerrarMenuResponsivo();
                    });
            }
        },
        _abrirMenuResponsivo: function () {
            let _this = this;
            _this.menu.addClass('menu-abierto');
        },
        _cerrarMenuResponsivo: function () {
            let _this = this;
            _this.menu.removeClass('menu-abierto');
        }
    };


};

// Funcion para loguear
function _d(d, v) {
    if ($.Vacker.opciones.debug) {
        m = d;
        if (v || v === 0 || v === false) {
            m = m + " : " + v;
        }
        console.log(m);
    }
}
