<?php

use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Usuarios seed.
 */
class UsuariosSeed extends AbstractSeed
{
    /**
     * Metodo Run.
     *
     * Ingresa "semillas" (seeds) a la base de datos
     *
     * @return void
     */
    public function run()
    {
        // Para clear las claves cifradas
        $hasher = new DefaultPasswordHasher();

        $data = [
            [
                'email' => 'admin@syloper.com',
                'password' => $hasher->hash('123'),
                'nombre' => 'Admin',
                'apellido' => 'Syloper',
                'rol' => 'admin',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
        ];

        $table = $this->table('usuarios');
        $table->insert($data)->save();
    }
}
