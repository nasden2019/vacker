<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\I18n\Time;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Mailer\Email;
// use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component\CookieComponent;

/**
 * Paginas Controller
 */
class PaginasController extends AppController
{

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(){
        parent::initialize();
    }

    //Se sacó de $this->Auth->allow la clave 'gratis', el método está comentado.
    public function beforeFilter(Event $event){
        $this->Auth->allow([
            'iniciarSesion',
            'comoFunciona',
            'precios',
            //'preciosPrueba',
            'buscarAlimentos',
            'buscarAlimentosR',
            'inscribirme',
            'opciones',
            'contacto',
            'contactoEmpresas',
            'casos',
            'caso',
            'evaluar',
            'borrarResultados',
            'borrarCarrito',
            'individual',
            'tienda',
            'checkout',
            'carrito',
            'carritocampos',
            'bienvenido',
            'gracias',
            'transferencias',
            'confirmacion',
            'terminos',
            'conferencia',
            'evaluarAjax',
            'validarEmailAjax',
            'empresas'
        ]);
    }

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Paginas.id' => 'desc'
        ]
    ];

    public function index(){
        $paginas = $this->paginate($this->Paginas->find('all'));
        $this->set(compact('paginas'));
        $this->set('_serialize', ['paginas']);
    }

    public function editar($id = null){
       
        $pagina = $this->Paginas->get($id);
        $metas = [];

        if ($this->request->is(['patch', 'post', 'put'])) {
        
            $data = [];

            $this->request->data['data']  = serialize($data);
            $this->request->data['metas'] = serialize($this->request->data['meta']);

            if(!empty($this->request->data['imagen']['name'])){
                $destino = WWW_ROOT.'img'.DS.'paginas'.DS;
                $valor = $this->imagenes($this->request->data['imagen'], $destino, 'agregar');
                if(!$valor){
                    $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                    return $this->redirect(['action' => 'editar']);
                }
                $this->request->data['imagen'] = $valor['imagen'];
            }else{
                $this->request->data['imagen'] = $pagina->imagen;
            }
           
            $pagina = $this->Paginas->patchEntity($pagina, $this->request->data);
            if ($this->Paginas->save($pagina)) {
                $this->Flash->sPublico(__('La página se edito con éxito.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->ePublico(__('Hubo un error al editar. Por favor intenta nuevamente.'));
            }
        }

        if (!empty($pagina->metas)) {
            $metas = unserialize($pagina->metas);
            $mm = [];
            foreach ($metas as $key => $array) {
                if (!empty($array['content'])) {
                    reset($array);
                    list($clave, $valor) = each($array);
                    $mm[$valor] = $array['content'];
                }
            }
            $metas = $mm;
        }

        // debug($pagina);die();

        $this->set(compact('pagina','metas'));
        $this->set('_serialize', ['pagina','metas']);
    }


}