<?php
namespace App\Model\Table;

use App\Model\Entity\Pagina;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaginasTable extends Table{

    public function initialize(array $config){
        parent::initialize($config);
        
        $this->table('paginas');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator){
        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Este Slug ya se encuentra registrado.'
            ]);
	
        return $validator;
    }
}
