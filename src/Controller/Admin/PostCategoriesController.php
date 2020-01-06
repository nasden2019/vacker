<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class PostCategoriesController extends AppController
{

    private $destino = '';
    
    /**
     * 
     */


    public function initialize()
    {
        parent::initialize();
        
        $this->destino = WWW_ROOT.'img'.DS.'productos'.DS;
    }
    
    public function isAuthorized($user)
    {  
        return parent::isAuthorized($user);
    }
    /**
     * */


    public function beforeFilter(Event $event){
        $this->Auth->allow(['login','registro','recordarContrasenia','cambiarPassword']);
    }


    public function index()
    {
        $userLogin = $this->request->session()->read('Auth.Usuario');
        $this->set(compact('userLogin'));

        $category = $this->PostCategories->find();

        if($this->request->is(['post', 'get'])){
           if(!empty($this->request->query['search'])){
               if((strlen($this->request->query['search']) >= 3)){
                   $category->where(['PostCategories.name LIKE' => '%' . $this->request->query['search'] . '%']);
               }else{
                   $this->Flash->ePublico(__('Para la busqueda se necesitan 3 caracteres o más.'));
               }
           }
        }

        $category = $this->paginate($category);
        $this->set(compact('category'));
    }

    /**
     * 
     */
    public function agregar()
    {
        $userLogin = $this->request->session()->read('Auth.Usuario');
        $category = $this->PostCategories->newEntity();

        if ($this->request->is('post')) 
        {

            $category = $this->PostCategories->patchEntity($category, $this->request->data);

            if ($this->PostCategories->save($category)) 
            {
                $this->Flash->sPublico(__('La categoría se guardó con exito.'));
                return $this->redirect(['action' => 'index']);
            } else 
            {
                $this->Flash->ePublico(__('Hubo un error al guardar. Por favor intenta nuevamente.'));
            }
        }

        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Editar
     *
     * @param [type] $id
     * @return void
     */
    public function editar($id)
    {
        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }

        $userLogin = $this->request->session()->read('Auth.Usuario');
       
        $category = $this->PostCategories->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->PostCategories->patchEntity($category, $this->request->data);
            if ($this->PostCategories->save($category)) 
            {
                $this->Flash->sPublico('Categoría editada con éxito.');
                return $this->redirect($this->referer());
            } else 
            {
                $this->Flash->ePublico('Ocurrió un erro al editar la categoría.');
            }
        }
        $this->set(compact('category'));
    }
    
    public function eliminar($id = null)
    {

        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->PostCategories->get($id);
        if ($this->PostCategories->delete($category)) {
            $this->Flash->sPublico(__('La categoría ha sido borrado correctamente.'));
        } else {
            $this->Flash->ePublico(__('La categoría no pudo ser borrado. Por favor, intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
