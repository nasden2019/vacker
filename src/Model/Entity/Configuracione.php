<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Configuracione extends Entity{

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

}

?>