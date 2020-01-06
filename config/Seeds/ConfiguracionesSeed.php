<?php
use Migrations\AbstractSeed;

/**
 * Configuraciones seed.
 */
class ConfiguracionesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'facebook' => 'facebook.com',
                'youtube' => 'youtube.com',
                'instagram' => 'instagram.com',
                'telefono' => '555-5555',
                'email' => 'email@email.com',
                'terminos_cond' => 'terminos-condiciones',
                'modified' => date('Y-m-d H:i:s')
            ],
        ];

        $table = $this->table('configuraciones');
        $table->insert($data)->save();
    }
}
