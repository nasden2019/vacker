<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;

class Pagina extends Entity{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function _getRutaImagen(){
        return ($_SERVER['HTTP_HOST'] == 'localhost')? '/doctorya/webroot/img/paginas/'.$this->imagen : '/webroot/img/paginas/'.$this->imagen;
    }

    /*protected function _getSlug(){
        return strtolower(Inflector::slug($this->_properties['nombre']));
    }*/

}