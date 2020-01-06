<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class UsuariosController extends AppController
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

    public function beforeFilter(Event $event){
        $this->Auth->allow(['login','registro','recordarContrasenia','cambiarPassword']);
    }


    /**
     * 
     */
    public function logout()
    {
        $this->Cookie->delete('Usuario');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * @todo Agregar un mensaje de bienvenida ?
     */
    public function login()
    {

        $this->viewBuilder()->layout('public');
        // Si el Usuario tiene la sesion iniciada lo redireccionamos

        if ($this->Auth->user()) {
            return $this->redirect([
                'controller' => 'Usuarios',
                'action' => 'perfil'
            ]);
        }

        if($this->request->is('post')){

            $usuario = $this->Auth->identify();

            if ($usuario) {
                $this->Auth->setUser($usuario);
                if(!empty($this->request->data('remember_me'))){
                    $this->Cookie->write('Usuario', [ 
                        'email' => $this->request->data['email'],
                        'password' => $this->request->data['password']
                    ]);
                }
                
                $this->Flash->sPublico(__('Ingresaste a tu cuenta.'));
                return $this->redirect([
                    'controller' => 'Usuarios',
                    'action' => 'perfil'
                ]);
            }
            $this->Flash->ePublico(__('Usuario y/o contraseña incorrectos!.'));
        }else{
            // Logeo con cookies
            if(!$this->Auth->user() && $this->Cookie->check('Usuario')){
                $cookie = $this->Cookie->read('Usuario');
                $this->request->data['email'] = $cookie['email'];
                $this->request->data['password'] = $cookie['password'];
                if($this->request->data){
                    $usuario = $this->Auth->identify();
                    if ($usuario) {
                        $this->Auth->setUser($usuario);
                        $this->Flash->sPublico(__('Ingresaste a tu cuenta.'));
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                }
            }
        }
    }

    /**
     * 
     */

    public function registro()
    {
        $this->viewBuilder()->layout('public');

        $user = $this->Usuarios->newEntity();

        if($this->request->is(['patch', 'post', 'put'])) {

            $user = $this->Usuarios->patchEntity($user, $this->request->data);

            if ($this->Usuarios->save($user)) {

                $data = array($user->email,$this->request->data['password']);

                $email = new Email('default');
                $email->from(['soporte@base.com.ar' => 'base'])
                      ->template('registro', 'default')
                      ->emailFormat('html')
                      ->to($user->email)
                      ->subject('Registro Exitoso.')
                      ->viewVars(['data' => $data])
                      ->send();

                $this->Flash->sPublico(__('Gracias por registrarte.'));
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'Usuarios','action' => 'perfil']);
            } else {
                $this->Flash->ePublico(__('Hubo un error. Por favor intenta nuevamente.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
        $this->set(compact('usuario'));
    }

    
    /**
     * 
     */
    
    public function perfil()
    {   

        $this->viewBuilder()->layout('public');

        $user = $this->Usuarios->get($this->Auth->user()['id']);

        if($this->request->is(['patch', 'post', 'put'])){


            //valida que exista una imagen
            if((empty($user->imagen)) AND (empty($this->request->data['imagen']))){
                $this->Flash->ePublico(__('Debe ingresar una Imagen'));
                return $this->redirect(['action' => 'perfil']);
            }


            if(!empty($this->request->data['imagen']['name'])){
                
                $ruta = WWW_ROOT.'img'.DS.'perfiles'.DS;
                //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                $valor = $this->imagenes($this->request->data['imagen'], $ruta);
                if(!$valor['estado']){
                    $this->Flash->ePublico(__($valor['mensaje']));
                    return $this->redirect(['action' => 'perfil']);
                }
                $this->request->data['imagen'] = $valor['imagen'];

            }else{
                $this->request->data['imagen'] = $user->imagen;
            }

            if(!empty($this->request->data['fecha_nacimiento'])){
                $this->request->data['fecha_nacimiento'] = Time::createFromFormat('d/m/Y', $this->request->data['fecha_nacimiento'], 'America/Argentina/Buenos_Aires');
            }

            if (!empty($this->request->data['nuevo_pass']) AND !empty($this->request->data['repetir_pass'])) {
                if($this->request->data['nuevo_pass'] != $this->request->data['repetir_pass']){
                    $this->Flash->ePublico('Las Contraseñas no coinciden, intente nuevamente.');
                    return $this->redirect(['action' => 'perfil']);
                } else {
                    $this->request->data['password'] = $this->request->data['nuevo_pass'];
                    $this->Flash->sPublico('La Contraseña se cambió con éxito.');
                }
            }

            $user = $this->Usuarios->patchEntity($user, $this->request->data);

            if ($this->Usuarios->save($user)) {
                $this->Flash->sPublico('Los cambios se guardaron con éxito.');
                if ($this->Auth->user('id') === $user->id) {
                    $this->request->data = $user->toArray();
                    unset($this->request->data['password']);
                    $this->Auth->setUser($this->request->data);
                }

            }else{
                $this->Flash->ePublico('Ocurrió un error al modificar el perfil, por favor intentá nuevamente.');
            }
        }

        $titulo = 'Mi perfil';

        $this->set(compact('user', 'titulo'));

    }

    public function recordarContrasenia()
    {
        $this->viewBuilder()->layout('public');

        $titulo = "Restablecer contraseña";
        if($this->request->is('post')){

            $email = $this->request->data['email'];
            $user = $this->Usuarios->find('all')->where(['email' => $email])->first();
            if($user){
                $clave = uniqid();
                $user->clave = $clave;
                $caducidad = new Time('now');
                $caducidad->modify('+1 days');
                $caducidad->i18nFormat('yyyy-MM-dd HH:mm:ss');            
                $user->caducidad = $caducidad;
                $this->Usuarios->save($user);

                $usuario = [];
                $usuario[0] = $user->nombre;
                $usuario[1] = $user->email;
                $usuario[2] = $user->clave;
                $usuario[3] = $user->caducidad;

                $email_recordarcontraseña = new Email();
                $email_recordarcontraseña->template('recordar', 'default')
                    ->emailFormat('html')
                    ->viewVars(['user' => $usuario])
                    ->from(['no-reply@base.com.ar' => 'BASE'])
                    ->subject('Restaurar tu contraseña')
                    ->to('lucparra@gmail.com')
                    ->bcc($user->email);
                
                $email_recordarcontraseña->send();

                $this->Flash->sPublico(__('El mail se envió correctamente.'));
                $this->redirect(['controller' => 'Usuarios','action' => 'login']);

            }else{
                $this->Flash->ePublico(__('El email ingresado no existe en nuestra base de datos.'));
            } 
        }    
        $this->set(compact('titulo'));
    }

    public function cambiarPassword()
    {

        $this->viewBuilder()->layout('public');
        $estado = false;
        
        if($this->request->is('post')) {
            try {
                if(empty($this->request->data['email'])) {
                    $this->Flash->ePublico(__("Ups.. ha ocurrido un error."));
                    //throw new \Exception("El campo 'Nueva contraseña', no puede estar vacio.");
                }
                if(empty($this->request->data['clave'])) {
                    $this->Flash->ePublico(__("Ups.. ha ocurrido un error."));
                    //throw new \Exception("El campo 'Nueva contraseña', no puede estar vacio.");
                }
                if(empty($this->request->data['nuevo_pass'])) {
                    $this->Flash->ePublico(__("El campo 'Nueva contraseña', no puede estar vacio."));
                    throw new \Exception("El campo 'Nueva contraseña', no puede estar vacio.");
                }
                if(empty($this->request->data['repetir_pass'])) {
                    $this->Flash->ePublico(__("El campo 'Repetir contraseña', no puede estar vacio."));
                    throw new \Exception("El campo 'Repetir contraseña', no puede estar vacio.");
                }
                if($this->request->data['nuevo_pass'] != $this->request->data['repetir_pass']){
                    $this->Flash->ePublico(__("Ups.. no se pudo identificar. Puede que no este registrado, pruebe cambiando la contraseña nuevamente."));
                    throw new \Exception("Las contraseñas no coinciden.");
                }
                
                $usuario = $this->Usuarios->find()
                    ->where([
                        'email' => $this->request->data['email'],
                        'clave'  => $this->request->data['clave']
                    ])
                    ->firstOrFail();

                $dateTime = new Time($usuario->expiro_cambio_pass);
                $now = new Time();
                $interval = $now->diff($dateTime);

                if($interval->invert == 0){

                    $usuario->password = $this->request->data['nuevo_pass'];
                    $usuario->clave = null;
                    
                    if (!$this->Usuarios->save($usuario)) 
                        throw new \Exception("La contraseña no se pudo cambiar. Intente nuevamente.");
                    
                    $this->Flash->sPublico(__('La contraseña ha sido cambiada.'));
                    
                    $data = array($usuario->email,$this->request->data['nuevo_pass']);

                    $email = new Email('default');
                    $email->from(['soporte@base.com.ar' => 'BASE'])
                          ->template('gracias_password', 'default')
                          ->emailFormat('html')
                          ->to($usuario->email)
                          ->subject('Cambio de contraseña.')
                          ->viewVars(['data' => $data])
                          ->send();
                    
                   return $this->redirect(['controller' => '/', 'action' => 'login']);

                }else{

                    $this->Flash->ePublico(__('El tiempo para cambiar la clave se venció, por favor iniciá la solicitud nuevamente.'));
                    return $this->redirect(['controller' => '/', 'action' => 'login']);

                }

            } catch (\Exception $e) {
                $this->set(compact('estado')); 
                $this->Flash->ePublico(__('Ups.. ha ocurrido un error.'));
            }

        }
    }
}
