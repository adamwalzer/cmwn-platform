<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class FlipAcknowledge
 */
class FlipAcknowledge extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('user_flips');

        if (!$table->hasColumn('acknowledge_id')) {
            $table->addColumn('acknowledge_id', 'string', ['null' => true])
                ->save();
        }

        $this->execute(
            'UPDATE user_flips ' .
            'SET acknowledge_id = NULL, flip_id = flip_id, user_id = user_id, earned = earned'
        );
    }
}
