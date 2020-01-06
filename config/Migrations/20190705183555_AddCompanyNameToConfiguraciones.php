<?php
use Migrations\AbstractMigration;

class AddCompanyNameToConfiguraciones extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('configuraciones');
        $table->addColumn('company_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'after' => 'id',
        ]);
        $table->update();
    }
}
