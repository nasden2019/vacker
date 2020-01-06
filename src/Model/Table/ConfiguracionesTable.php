<?php
namespace App\Model\Table;

use App\Model\Entity\Configuracione;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConfiguracionesTable extends Table{

    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setTable('configuraciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
    }

    
}