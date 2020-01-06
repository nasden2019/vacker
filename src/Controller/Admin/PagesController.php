<?php
namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    /**
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logs']);
    }

    /**
     * 
     */
    public function dashboard()
    {
        
        $userLogin = $this->request->session()->read('Auth.Usuario');
        $this->set(compact('userLogin'));

    }

    /**
     * 
     */
    public function logs()
    {
        $this->autoRender = false;

    }
}
