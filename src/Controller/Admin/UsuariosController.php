<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\View\Helper\SessionHelper;
use Cake\ORM\TableRegistry;

class UsuariosController extends AppController
{

    private $destino = '';
    
    /**
     * 
     */
    public $genero = [
        'M' => 'Masculino',
        'F' => 'Femenino'
    ];
    
    /**
     * 
     */
    public $roles = [
        'admin' => 'Administrador', 
        'usuario' => 'Usuario',
        'secretaria' => 'Secretaria',
        'profesional' => 'Profesional'
    ];

    /**
     * 
     */

    public function initialize()
    {
        parent::initialize();
        
        $this->destino = WWW_ROOT.'img'.DS.'perfiles'.DS;
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

        $usuarios = $this->Usuarios->find();

        $usuarios = $this->paginate($usuarios);
        $this->set(compact('usuarios'));
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
        $this->viewBuilder()->layout('login');
        
        /**
         * Si el usuario ya se encuentra logueado
         * lo redireccionamos al lugar de donde vino.
         * 
         */
        if ($this->request->session()->check('Auth.Usuario')) 
            return $this->redirect($this->Auth->redirectUrl());

        if($this->request->is('post')){
            $usuario = $this->Auth->identify();
            if ($usuario) {
                if(($usuario['rol'] == 'admin')){
                    $this->Auth->setUser($usuario);
                    if($this->request->data('remember_me') === '1'){
                        $this->Cookie->write('Usuario',
                            ['email' => $this->request->data['email'],
                            'password' => $this->request->data['password']]
                        );
                    }
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $this->Flash->ePublico(__('Usuario y/o contraseña incorrectos!.'), ['key' => 'auth']);
        }

        if(!$this->Auth->user() && $this->Cookie->check('Usuario')){
            $cookie = $this->Cookie->read('Usuario');
            $this->request->data['email'] = $cookie['email'];
            $this->request->data['password'] = $cookie['password'];
            if($this->request->data){
                $usuario = $this->Auth->identify();
                if ($usuario) {
                    $this->Auth->setUser($usuario);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }

    }

    /**
     * 
     */
    public function agregar()
    {

        $userLogin = $this->request->session()->read('Auth.Usuario');

        $user = $this->Usuarios->newEntity();

        if ($this->request->is('post')) {

            if(!empty($this->request->data['imagen']['name'])){

                $destino = WWW_ROOT.'img'.DS.'perfiles'.DS;
                //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                $valor = $this->imagenes($this->request->data['imagen'], $destino, 'agregar');
                $this->request->data['imagen'] = $valor['imagen'];
                if(!$valor){
                    $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                    return $this->redirect(['action' => 'agregar']);
                }

            }else{
                $this->request->data['imagen'] = "default.png";
            }

            $user = $this->Usuarios->patchEntity($user, $this->request->data);
            if ($this->Usuarios->save($user)) {
                $this->Flash->sPublico(__('El usuario se guardó con exito.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->ePublico(__('Hubo un error al guardar. Por favor intenta nuevamente.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

        $this->set('genero',$this->genero);
        $this->set('roles',$this->roles);
        $this->set(compact('usuario','userLogin'));
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
       
        $usuario = $this->Usuarios->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

             if(!empty($this->request->data['imagen']['name'])){

                $destino = WWW_ROOT.'img'.DS.'perfiles'.DS;
                //la funcion imagenes va a guardar la nueva imagen y borrar la anterior, devuelve el nuevo nombre.
                $valor = $this->imagenes($this->request->data['imagen'], $destino, 'agregar');
                $this->request->data['imagen'] = $valor['imagen'];
                if(!$valor){
                    $this->Flash->ePublico(__('Error al procesar la imagen. intente nuevamente.'));
                    return $this->redirect(['action' => 'agregar']);
                }

            }else{
                $this->request->data['imagen'] = $usuario->imagen;
            }

            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->sPublico('Usuario editado con éxito.');
                return $this->redirect($this->referer());
            } else {
                $this->Flash->ePublico('Ocurrió un errro al crear usuario.');
            }
        }

        $this->set('genero',$this->genero);
        $this->set('roles',$this->roles);
        $this->set(compact('usuario','userLogin'));
    }

    /**
     * 
     */
    public function loginWith($id)
    {
        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }

        $this->autoRender = false;

        // $super_ADMIN = unserialize(SA);
        $habilitados = [1];

        if(in_array($this->Auth->user('id'), $habilitados)){

            $usuario = $this->Usuarios->get($id)->toArray();
            if ($usuario) {
                //$this->Auth->logout();
                $this->Auth->__set('sessionKey', 'Auth.Usuario');
                $this->Auth->setUser($usuario);
                $this->Flash->sPublico('Accediste como '.$usuario['nombre']);
                //return $this->redirect($this->Auth->config('loginRedirect'));
                return $this->redirect(['controller' => 'Usuarios', 'action' => 'index']);
            }else{
                $this->Flash->ePublico('No existe el usuario con ese ID.');
                return $this->redirect(['action' => 'index']);
            }
        }else{
            return $this->redirect(['action' => 'index']);
        }
    }
    
    public function perfil()
    {   
        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }
        

        $user = $this->Usuarios->find()
            ->where(['Usuarios.id' => $this->Auth->user()['id']])
            ->firstOrFail();


        if($this->request->is(['patch', 'post', 'put'])){

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

            $data = $this->request->data;

            if (!empty($data['nuevo_pass']) && !empty($data['repetir_pass'])) {
                if($data['nuevo_pass'] === $data['repetir_pass']){
                    $user = $this->Usuarios->patchEntity($user, [
                        'password' => $this->request->data['nuevo_pass'],
                        'nuevo_pass' => '',
                    ]);
                }else{
                    $this->Flash->ePublico('Las Contraseñas no coinciden, intente nuevamente.');
                }   
            }

            if(!empty($this->request->data['fecha_nacimiento'])){
                $this->request->data['fecha_nacimiento'] = Time::createFromFormat('d/m/Y', $this->request->data['fecha_nacimiento'], 'America/Argentina/Buenos_Aires');
            }

            $user = $this->Usuarios->patchEntity($user, $this->request->data);
            if ($this->Usuarios->save($user)) {

                $this->Flash->sPublico('Se modificaron los datos correctamente.');
                if ($this->Auth->user('id') === $user->id) {
                    $data = $user->toArray();
                    unset($data['password']);
                    $this->Auth->setUser($data);
                }

            }else{
                $this->Flash->ePublico('Ocurrió un error al modificar el perfil, por favor intentá nuevamente.');
            }

        }

        $titulo     = 'Mi perfil | DoctrorYa';

        $this->set('genero',$this->genero);
        $this->set(compact('user', 'titulo'));

    }
    
    public function eliminar($id = null)
    {

        if(!$this->validar_permisos(['admin'])){
            return $this->redirect([ 'controller' => 'Pages', 'action' => 'dashboard' ]);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($user)) {
            $this->Flash->sPublico(__('El usuario ha sido borrado correctamente.'));
        } else {
            $this->Flash->ePublico(__('El no pudo ser borrado. Por favor, intente nuevamente'));
        }

        return $this->redirect(['action' => 'index']);
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
                    ->from(['no-reply@doctorya.com.ar' => 'DoctorYA'])
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
                    $email->from(['soporte@doctorya.com.ar' => 'DoctorYA'])
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
