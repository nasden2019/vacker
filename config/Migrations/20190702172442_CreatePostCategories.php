<?php
use Migrations\AbstractMigration;

class CreatePostCategories extends AbstractMigration
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
        $table = $this->table('post_categories');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('post_categories_posts', [
            'id' =>false,
            'primary_key' => ['post_id', 'post_category_id']
        ]);
        $table->addColumn('post_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('post_category_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('posts');
        $table->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
        ]);
        $table->update();
    }
}
