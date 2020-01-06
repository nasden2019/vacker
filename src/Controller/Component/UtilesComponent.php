<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Utiles component
 */
class UtilesComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * slugMeiquer method
     *
     * @param string $frase && string $controller && string $campo
     * @return string $slug
     */
    public function slugMeiquer($frase, $controller, $campo)
    {

        try {
            $stop_words = ['a', 'acá', 'ahí', 'ajena', 'ajeno', 'ajenas', 'ajenos', 'al', 'algo', 'algún', 'alguna', 'alguno', 'algunas', 'algunos', 'allá', 'allí', 'ambos', 'ante', 'antes', 'aquel', 'aquella', 'aquellas', 'aquello', 'aquellos', 'aquí', 'arriba', 'así', 'atrás', 'aun', 'aunque', 'bajo', 'bastante', 'bien', 'cabe', 'cada', 'casi', 'cierto', 'cierta', 'ciertos', 'ciertas', 'como', 'con', 'conmigo', 'conseguimos', 'conseguir', 'consigo', 'consigue', 'consiguen', 'consigues', 'contigo', 'contra', 'cual', 'cuales', 'cualquier', 'cualquiera', 'cualquieras', 'cuan', 'cuando', 'cuanto', 'cuanta', 'cuantos', 'cuantas', 'de', 'dejar', 'del', 'demás', 'demasiada', 'demasiado', 'demasiadas', 'demasiados', 'dentro', 'desde', 'donde', 'dos', 'el', 'él', 'ella', 'ello', 'ellas', 'ellos', 'empleáis', 'emplean', 'emplear', 'empleas', 'empleo', 'en', 'encima', 'entonces', 'entre', 'era', 'eras', 'eramos', 'eran', 'eres', 'es', 'esa', 'ese', 'eso', 'esas', 'eses', 'esos', 'esta', 'estas', 'estaba', 'estado', 'estáis', 'estamos', 'están', 'estar', 'este', 'esto', 'estes', 'estos', 'estoy', 'etc', 'fin', 'fue', 'fueron', 'fui', 'fuimos', 'gueno', 'ha', 'hace', 'haces', 'hacéis', 'hacemos', 'hacen', 'hacer', 'hacia', 'hago', 'hasta', 'incluso', 'intenta', 'intentas', 'intentáis', 'intentamos', 'intentan', 'intentar', 'intento', 'ir', 'jamás', 'junto', 'juntos', 'la', 'lo', 'las', 'los', 'largo', 'más', 'me', 'menos', 'mi', 'mis', 'mía', 'mías', 'mientras', 'mío', 'míos', 'misma', 'mismo', 'mismas', 'mismos', 'modo', 'mucha', 'muchas', 'muchísima', 'muchísimo', 'muchísimas', 'muchísimos', 'mucho', 'muchos', 'muy', 'nada', 'ni', 'ningún', 'ninguna', 'ninguno', 'ningunas', 'ningunos', 'no', 'nos', 'nosotras', 'nosotros', 'nuestra', 'nuestras', 'nuestro', 'nuestros', 'nunca', 'os', 'otra', 'otro', 'otras', 'otros', 'para', 'parecer', 'pero', 'poca', 'pocas', 'poco', 'pocos', 'podéis', 'podemos', 'poder', 'podría', 'podrías', 'podríais', 'podríamos', 'podrían', 'por', 'por qué', 'porque', 'primero', 'puede', 'pueden', 'puedo', 'pues', 'que', 'qué', 'querer', 'quién', 'quiénes', 'quienesquiera', 'quienquiera', 'quizá', 'quizás', 'sabe', 'sabes', 'saben', 'sabéis', 'sabemos', 'saber', 'se', 'según', 'ser', 'si', 'sí', 'siempre', 'siendo', 'sin', 'sino', 'so', 'sobre', 'sois', 'solamente', 'solo', 'sólo', 'somos', 'soy', 'sr', 'sra', 'sres', 'sta', 'su', 'sus', 'suya', 'suyas', 'suyo', 'suyos', 'tal', 'tales', 'también', 'tampoco', 'tan', 'tanta', 'tantas', 'tanto', 'tantos', 'te', 'tenéis', 'tenemos', 'tener', 'tengo', 'ti', 'tiempo', 'tiene', 'tienen', 'toda', 'todas', 'todo', 'todos', 'tomar', 'trabaja', 'trabajo', 'trabajáis', 'trabajamos', 'trabajan', 'trabajar', 'trabajas', 'tras', 'tú', 'tu', 'tus', 'tuya', 'tuyas', 'tuyo', 'tuyos', 'último', 'ultimo', 'un', 'una', 'unas', 'uno', 'unos', 'usa', 'usas', 'usáis', 'usamos', 'usan', 'usar', 'uso', 'usted', 'ustedes', 'va', 'van', 'vais', 'valor', 'vamos', 'varias', 'varios', 'vaya', 'verdadera', 'vosotras', 'vosotros', 'voy', 'vuestra', 'vuestras', 'vuestro', 'vuestros', 'y', 'ya', 'yo'];
            $caracteres_esp = ['/', '-', '_', '?', '¿', '\\', '"', '\'', '!', '¡'];

            $frase = mb_strtolower($frase);
            $frase_sin_caracteres = str_replace($caracteres_esp, " ", $frase);
            $array_frase = explode(' ', $frase_sin_caracteres);
            foreach ($array_frase as $k => $v) {
                if(in_array($v, $stop_words)) unset($array_frase[$k]);
            }
            $frase_nueva = implode(' ', $array_frase);

            $slug = Inflector::slug($frase_nueva, '-');

            $tabla = TableRegistry::get($controller);
            $num = []; $maximo = 0;

            $existe_slug = $tabla->find()->select($campo)->where([$campo => $slug])->hydrate(false)->first();
            if($existe_slug){
                $busco_otros_slug = $tabla->find()->select($campo)->where([$campo . ' LIKE' => ('%'.$slug.'%')])->hydrate(false);
                if($busco_otros_slug->count() > 0){
                    foreach ($busco_otros_slug as $k => $s) {
                        $replace = str_replace($slug, "", $s[$campo]);
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
