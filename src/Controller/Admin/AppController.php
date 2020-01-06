<?php
namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\CookieComponent;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Log\Log;


require_once(ROOT.DS. 'vendor'.DS.'ImageTool.php');
use ImageTool;

class AppController extends Controller{
    
    public $helpers = [
       'Paginator' => ['templates' => 'paginator-templates']
    ];
    
    public function isAuthorized($user)
    {  
        return $this->validar_permisos(['admin']);
    }

    public function initialize()
    {
        parent::initialize();

        Configure::write('Session.timeout', '60');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Utiles');
        Time::$defaultLocale = 'es-ES';
        Time::setJsonEncodeFormat('dd-MM-yyyy HH:mm:ss');
        
        $this->loadComponent('Auth', [
            'loginRedirect' => [ 'controller' => '/', 'action' => 'dashboard'],
            'logoutRedirect' => [ 'controller' => '/', 'action' => 'login'],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'userModel' => 'Usuarios'
                ]
            ],
            'storage' => ['className' => 'Session', 'key' => 'Auth.Usuario'],
            'loginAction' => [ 'controller' => '/', 'action' => 'login'],
            'unauthorizedRedirect' => $this->referer(),
            'authorize' => 'Controller',
            'authError' => false,
        ]);
        
        $this->Auth->__set('sessionKey', 'Auth.Usuario');

        $userLogin = $this->request->session()->read('Auth.Usuario');
        $this->set(compact('userLogin'));
    }

    /**
     * 
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * 
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['login', 'logout']);
        $this->set('current_user', $this->request->session()->read('Auth.Usuario'));
        $this->Cookie->configKey('Usuario', 'path', '/');
        $this->Cookie->configKey('Usuario', [
            'expires' => '+10 days',
            'httpOnly' => true
        ]);
    }

    public function validar_permisos($permiso = [])
    {
        $usrActual = $this->Auth->user();
        return (!empty($usrActual) && in_array($usrActual['rol'], $permiso)) ? true : false;
    }
    
    public function imagenes($i, $destino, $imagenAnt = null)
    {
        $r = ['estado' => false, 'mensaje' => '', 'imagen' => ''];
        $f = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
        $existe_destino = false;
        if (is_dir($destino)) {
            $existe_destino = true;
        } else {
            if (mkdir($destino, 0777)) $existe_destino = true;
        }
        if ($existe_destino) {
            if (!empty($i['name'])) {

                if (in_array($i['type'], $f)) {

                    $ext = substr(strtolower(strrchr($i['name'], '.')), 1);
                    $nn = uniqid();
                    $re = ImageTool::resize(array(
                        'input' => $i['tmp_name'],
                        'output' => $destino . $nn . '.' . $ext,
                        'width' => 1300,
                        'enlarge' => false,
                        'mode' => 'fit',
                        'paddings' => false
                    ));

                    if ($re) {
                        $r['imagen'] = $nn . '.' . $ext;
                        $r['mensaje'] = __("La imagen se subió correctamente");
                        $r['estado'] = true;

                        if (!empty($imagenAnt)) {
                            if ($imagenAnt != "default.png") {
                                @unlink($destino . $imagenAnt);
                            }
                        }
                    } else {
                        $r["mensaje"] = __("Ocurrió un error al guardar imagen.");
                    }
                } else {
                    $r["mensaje"] = __("El formato de imagen es incorrecto.");
                }
            } else {
                $r["mensaje"] = __("La imagen no se subió correctamente.");
            }
        } else {
            $r["mensaje"] = __("La carpeta donde intenta guardar la imagen, no existe y no pudo ser creada.");
        }
        return $r;
    }

    public function archivos($i, $destino, $imagenAnt = null)
    {
        $r = ['estado' => false, 'mensaje' => '', 'archivo' => ''];
        $f = array(
        'application/pdf', //pdf
        'application/vnd.oasis.opendocument.text', //odt
        'application/msword',  //doc
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //dcx
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //xlsx
        'application/vnd.ms-excel', //xls
        'application/vnd.ms-powerpoint', //ppt
        'application/vnd.oasis.opendocument.spreadsheet' //ods
        );
        $existe_destino = false;
        if (is_dir($destino)) {
            $existe_destino = true;
        } else {
            //if (mkdir($destino, 0777)) $existe_destino = true;
            $existe_destino = true;
        }
        if ($existe_destino) {
            if (!empty($i['name'])) {

                if (in_array($i['type'], $f)) {

                    $ext = substr(strtolower(strrchr($i['name'], '.')), 1);
                    $name = basename($i["name"],'.'.$ext);
                    $nn = trim(strtolower($name));
                    $nom =explode(" ", $nn);
                    $nombre = implode("-", $nom);
                    $r['archivo'] = $nombre . '.' . $ext;

                    $r['mensaje'] = __("El archivo se subió correctamente");
                    $r['estado'] = true;

                    $tmp_name = $i["tmp_name"];

                    if(move_uploaded_file($tmp_name, $destino.$r['archivo'])) {
                        //
                    } else {
                        $r["mensaje"] = __("Hubo un error al subir el archivo");
                    }

                } else {
                    $r["mensaje"] = __("El formato de archivo es incorrecto.");
                }
            } else {
                $r["mensaje"] = __("El archivo no se subió correctamente.");
            }
        } else {
            $r["mensaje"] = __("La carpeta donde intenta guardar el archivo, no existe y no pudo ser creada.");
        }
        return $r;
    }

    public function slugMeiquer($frase, $controller, $usarStopWords = true)
    {

        try {

            $caracteres_esp = ['/', '-', '_', '?', '¿', '\\', '"', '\'', '!', '¡'];
            
            $frase = mb_strtolower($frase);
            $frase_sin_caracteres = str_replace($caracteres_esp, " ", $frase);
            
            $array_frase = explode(' ', $frase_sin_caracteres);
            
            if ($usarStopWords) {
                $stop_words = ['a', 'acá', 'ahí', 'ajena', 'ajeno', 'ajenas', 'ajenos', 'al', 'algo', 'algún', 'alguna', 'alguno', 'algunas', 'algunos', 'allá', 'allí', 'ambos', 'ante', 'antes', 'aquel', 'aquella', 'aquellas', 'aquello', 'aquellos', 'aquí', 'arriba', 'así', 'atrás', 'aun', 'aunque', 'bajo', 'bastante', 'bien', 'cabe', 'cada', 'casi', 'cierto', 'cierta', 'ciertos', 'ciertas', 'como', 'con', 'conmigo', 'conseguimos', 'conseguir', 'consigo', 'consigue', 'consiguen', 'consigues', 'contigo', 'contra', 'cual', 'cuales', 'cualquier', 'cualquiera', 'cualquieras', 'cuan', 'cuando', 'cuanto', 'cuanta', 'cuantos', 'cuantas', 'de', 'dejar', 'del', 'demás', 'demasiada', 'demasiado', 'demasiadas', 'demasiados', 'dentro', 'desde', 'donde', 'dos', 'el', 'él', 'ella', 'ello', 'ellas', 'ellos', 'empleáis', 'emplean', 'emplear', 'empleas', 'empleo', 'en', 'encima', 'entonces', 'entre', 'era', 'eras', 'eramos', 'eran', 'eres', 'es', 'esa', 'ese', 'eso', 'esas', 'eses', 'esos', 'esta', 'estas', 'estaba', 'estado', 'estáis', 'estamos', 'están', 'estar', 'este', 'esto', 'estes', 'estos', 'estoy', 'etc', 'fin', 'fue', 'fueron', 'fui', 'fuimos', 'gueno', 'ha', 'hace', 'haces', 'hacéis', 'hacemos', 'hacen', 'hacer', 'hacia', 'hago', 'hasta', 'incluso', 'intenta', 'intentas', 'intentáis', 'intentamos', 'intentan', 'intentar', 'intento', 'ir', 'jamás', 'junto', 'juntos', 'la', 'lo', 'las', 'los', 'largo', 'más', 'me', 'menos', 'mi', 'mis', 'mía', 'mías', 'mientras', 'mío', 'míos', 'misma', 'mismo', 'mismas', 'mismos', 'modo', 'mucha', 'muchas', 'muchísima', 'muchísimo', 'muchísimas', 'muchísimos', 'mucho', 'muchos', 'muy', 'nada', 'ni', 'ningún', 'ninguna', 'ninguno', 'ningunas', 'ningunos', 'no', 'nos', 'nosotras', 'nosotros', 'nuestra', 'nuestras', 'nuestro', 'nuestros', 'nunca', 'os', 'otra', 'otro', 'otras', 'otros', 'para', 'parecer', 'pero', 'poca', 'pocas', 'poco', 'pocos', 'podéis', 'podemos', 'poder', 'podría', 'podrías', 'podríais', 'podríamos', 'podrían', 'por', 'por qué', 'porque', 'primero', 'puede', 'pueden', 'puedo', 'pues', 'que', 'qué', 'querer', 'quién', 'quiénes', 'quienesquiera', 'quienquiera', 'quizá', 'quizás', 'sabe', 'sabes', 'saben', 'sabéis', 'sabemos', 'saber', 'se', 'según', 'ser', 'si', 'sí', 'siempre', 'siendo', 'sin', 'sino', 'so', 'sobre', 'sois', 'solamente', 'solo', 'sólo', 'somos', 'soy', 'sr', 'sra', 'sres', 'sta', 'su', 'sus', 'suya', 'suyas', 'suyo', 'suyos', 'tal', 'tales', 'también', 'tampoco', 'tan', 'tanta', 'tantas', 'tanto', 'tantos', 'te', 'tenéis', 'tenemos', 'tener', 'tengo', 'ti', 'tiempo', 'tiene', 'tienen', 'toda', 'todas', 'todo', 'todos', 'tomar', 'trabaja', 'trabajo', 'trabajáis', 'trabajamos', 'trabajan', 'trabajar', 'trabajas', 'tras', 'tú', 'tu', 'tus', 'tuya', 'tuyas', 'tuyo', 'tuyos', 'último', 'ultimo', 'un', 'una', 'unas', 'uno', 'unos', 'usa', 'usas', 'usáis', 'usamos', 'usan', 'usar', 'uso', 'usted', 'ustedes', 'va', 'van', 'vais', 'valor', 'vamos', 'varias', 'varios', 'vaya', 'verdadera', 'vosotras', 'vosotros', 'voy', 'vuestra', 'vuestras', 'vuestro', 'vuestros', 'y', 'ya', 'yo'];
                foreach ($array_frase as $k => $v) {
                    if(in_array($v, $stop_words)) unset($array_frase[$k]);
                }
            }
            
            $frase_nueva = implode(' ', $array_frase);
            $slug = Inflector::slug($frase_nueva, '-');

            $tabla = TableRegistry::get($controller);
            $num = []; $maximo = 0;

            $existe_slug = $tabla->find()->select('slug')->where(['slug' => $slug])->hydrate(false)->first();
            if($existe_slug){
                $busco_otros_slug = $tabla->find()->select('slug')->where(['slug LIKE' => ('%'.$slug.'%')])->hydrate(false);
                if($busco_otros_slug->count() > 0){
                    foreach ($busco_otros_slug as $k => $s) {
                        $replace = str_replace($slug, "", $s['slug']);
                        if(!empty($replace) AND is_numeric($replace)){
                            $num[] = (int)$replace;
                        }
                    }
                    if(!empty($num)) $maximo = max($num);
                    $slug .= ($maximo+1);
                }
                return ['estado' => true, 'existe' => true, 'slug' => mb_strtolower($slug)];
            }
            return ['estado' => true, 'existe' => false, 'slug' => mb_strtolower($slug)];
            // return $slug;
        } catch (\Exception $e) {
            return ['existe' => false, 'existe' => '', 'slug' => '', 'mensaje' => $e->getMessage()];
        }
        
    }
}
