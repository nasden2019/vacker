<?php 
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class ConfiguracionesController extends AppController{

	public function editar()
    {
        
        $info = $this->Configuraciones->get(1);
        $titulo = "Editar Configuración";
        $this->set(compact('titulo','info'));
        if($this->request->is(['post', 'put']))
        {
            $info = $this->Configuraciones->patchEntity($info, $this->request->data);
            if($this->Configuraciones->save($info))
            {
                
                $this->Flash->sPublico('Se modificaron los datos correctamente.');
                return $this->redirect(['controller'=>'pages','action' => 'dashboard']);

            }
            else
            {
                $this->Flash->ePublico('Ha ocurrido un error, intente nuevamente');
            }
            
        } 
    }
}

?>