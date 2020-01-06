<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class PostsController extends AppController
{

    private $destino = '';
    
    /**
     * 
     */


    public function initialize()
    {
        parent::initialize();
        
        $this->destino = WWW_ROOT.'img'.DS.'posts'.DS;
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

        $posts = $this->Posts->find();

        if($this->request->is(['post', 'get'])){
            if(!empty($this->request->query['search'])){
                if((strlen($this->request->query['search']) >= 3)){
                    $posts->where([
                            'OR' => [
                                ['Posts.title LIKE' => '%' . $this->request->query['search'] . '%'],
                            ]
                        ]);
                }else{
                    $this->Flash->ePublico(__('Para la busqueda se necesitan 3 caracteres o más.'));
                }
            }
        }

        $posts = $this->paginate($posts);
        $this->set(compact('posts'));
    }

    /**
     * 
     */
    public function agregar()
    {
        $userLogin = $this->request->session()->read('Auth.Usuario');
        $post = $this->Posts->newEntity();

        if ($this->request->is('post')) 
        {
            if(!empty($this->request->data['img']['name']))
            {
                $destino = WWW_ROOT.'img'.DS.'posts'.DS;

                //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                $valor = $this->imagenes($this->request->data['img'], $destino, 'agregar');

                $this->request->data['img']= $valor['imagen'];

                if(!$valor)
                {
                    $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                    return $this->redirect(['action' => 'agregar']);
                }
            }

            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) 
            {
                $this->Flash->sPublico(__('El post se guardó con exito.'));
                return $this->redirect(['action' => 'index']);
            } else 
            {
                $this->Flash->ePublico(__('Hubo un error al guardar. Por favor intenta nuevamente.'));
            }
        }
        $this->set(compact('post'));
        $this->set('_serialize', ['post']);
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
       
        $post = $this->Posts->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

             if(!empty($this->request->data['img']['name'])){
                $destino = WWW_ROOT.'img'.DS.'posts'.DS;
                //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                $valor = $this->imagenes($this->request->data['img'], $destino, 'agregar');
                $this->request->data['img'] = $valor['imagen'];
                if(!$valor){
                    $this->Flash->ePublico(__('Error al procesar la img. intente nuevamente.'));
                    return $this->redirect(['action' => 'agregar']);
                }

            }else{
                $this->request->data['img'] = $post->img;
            }

            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->sPublico('Post editado con éxito.');
                return $this->redirect($this->referer());
            } else {
                $this->Flash->ePublico('Ocurrió un errro al dar de alta el post.');
            }
        }

        $this->set(compact('post'));
    }
    
    public function eliminar($id = null)
    {

        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->sPublico(__('El post ha sido borrado correctamente.'));
        } else {
            $this->Flash->ePublico(__('El post no pudo ser borrado. Por favor, intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
