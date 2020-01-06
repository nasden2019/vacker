if (typeof jQuery === "undefined") {
    throw new Error("ALMA necesita jQuery");
}

"use strict";

$.ALMA = {};
$.ALMA.opciones = {
    debug: true,
    local: ''
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
    
    $.ALMA.tinyMCE.iniciar();
    $.ALMA.select2.iniciar();

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
    $.ALMA.tinyMCE = {
        iniciar: function () {
            if ($('.editor').length) {
                tinymce.init({
                    selector: 'textarea',
                    height: 180,
                    setup: function (editor) {
                        editor.on('change', function () {
                            editor.save();
                        });
                    }
                });
            }
        }
    },

    /**
     * 
     */
    $.ALMA.select2 = {
        iniciar: function () {
            if ($('.select2').length) {
                $('.select2').select2({
                    language: "es"
                });
            }
        }
    }

    

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
