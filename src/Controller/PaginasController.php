<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PaginasController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function home()
    {
        $this->viewBuilder()->layout('publico');
        $this->loadModel('Products');
        $this->loadModel('Posts');
        $productos_destacados = $this->Products->find()->limit(3);
        $entradas = $this->Posts->find()->limit(3);
        $this->set(compact('productos_destacados', 'entradas'));
    }

    public function terminos()
    {
        $this->viewBuilder()->layout('publico');
        $this->loadModel("Configuraciones");

        $terminos = $this->Configuraciones->find()
            ->firstOrFail();
            
        $termino = $terminos->terminos_cond;

        $this->set(compact('termino'));

    }
}
