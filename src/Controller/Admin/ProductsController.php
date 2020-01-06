<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class ProductsController extends AppController
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

        $products = $this->Products->find();

        if($this->request->is(['post', 'get'])){
           if(!empty($this->request->query['search'])){
               if((strlen($this->request->query['search']) >= 3)){
                   $products->where([
                            'OR' => [
                                ['Products.name LIKE' => '%' . $this->request->query['search'] . '%'],
                                ['Products.description LIKE' => '%' . $this->request->query['search'] . '%'] 
                            ]
                        ]);
               }else{
                   $this->Flash->ePublico(__('Para la busqueda se necesitan 3 caracteres o más.'));
               }
           }
        }

        $products = $this->paginate($products);
        $this->set(compact('products'));
    }

    /**
     * 
     */
    public function agregar()
    {
        $userLogin = $this->request->session()->read('Auth.Usuario');
        $product = $this->Products->newEntity();

        if ($this->request->is('post')) 
        {
            for ($i=1; $i<5; $i++)
            {
                if(!empty($this->request->data['img'.$i]['name']))
                {
                    $destino = WWW_ROOT.'img'.DS.'products'.DS;

                    //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                    $valor = $this->imagenes($this->request->data['img'.$i], $destino, 'agregar');

                    $this->request->data['img'.$i] = $valor['imagen'];

                    if(!$valor)
                    {
                        $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                        return $this->redirect(['action' => 'agregar']);
                    }
                }
            }

            $product = $this->Products->patchEntity($product, $this->request->data);

            if ($this->Products->save($product)) 
            {
                $this->Flash->sPublico(__('El producto se guardó con exito.'));
                return $this->redirect(['action' => 'index']);
            } else 
            {
                $this->Flash->ePublico(__('Hubo un error al guardar. Por favor intenta nuevamente.'));
            }
        }
        $this->set(compact('product'));
        $this->set('_serialize', ['product']);
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
       
        $product = $this->Products->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            for ($i=1; $i<5 ; $i++) 
            { 
                if(!empty($this->request->data['img'.$i]['name']))
                {
                    $destino = WWW_ROOT.'img'.DS.'products'.DS;
                    //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                    $valor = $this->imagenes($this->request->data['img'.$i], $destino, 'agregar');
                    $this->request->data['img'.$i] = $valor['imagen'];
                    if(!$valor)
                    {
                        $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                        return $this->redirect(['action' => 'agregar']);
                    }
                }else
                {
                    $this->request->data['img'.$i] = $product['img'.$i];
                }
            }
            $product = $this->Products->patchEntity($product, $this->request->data);
            if ($this->Products->save($product)) 
            {
                $this->Flash->sPublico('Producto editado con éxito.');
                return $this->redirect($this->referer());
            } else 
            {
                $this->Flash->ePublico('Ocurrió un erro al dar de alta el producto.');
            }
        }
        $this->set(compact('product'));
    }
    
    public function eliminar($id = null)
    {

        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->sPublico(__('El producto ha sido borrado correctamente.'));
        } else {
            $this->Flash->ePublico(__('El producto no pudo ser borrado. Por favor, intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
