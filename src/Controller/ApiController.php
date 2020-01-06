<?php
namespace App\Controller;

/**
 * Clase para gestionas todos los pedidos por AJAX
 * 
 */
class ApiController extends AppController
{
    /**
     * Respuesta estandar
     *
     * @var array
     */
    private $respuesta = [
        'estado'  => false,
        'mensaje' => 'Ocurrió un error, intentá nuevamente.',
        'datos'   => [],
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        
        /**
         * Apagamos todas las vistas ya que van a ser meramente 
         * consultas por API
         * 
         */
        $this->autoRender = false;
        //$this->Auth->allow();
    }

   

}
