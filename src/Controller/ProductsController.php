<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class ProductsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->destino = WWW_ROOT.'img'.DS.'perfiles'.DS;
    }

    
    public function isAuthorized($user)
    {  
        return parent::isAuthorized($user);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow();
    }


    public function index()
    {
        $this->viewBuilder()->layout('publico');
        $products = $this->Products->find();
        $products = $this->paginate($products);
        $this->set(compact('products'));
    }
    public function view($id)
    {
        $this->viewBuilder()->layout('publico');
        $product = $this->Products->get($id);
        
        $this->set(compact('product'));
    }
}