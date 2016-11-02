<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class TodoInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_todo_statuses
        $table = $this->table('m_todo_statuses', array('id' => 'todo_status_id'));
        $table
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('ident', 'string', array('limit' => 255))
            ->addIndex(array('ident'), array('unique' => true))
            ->create();


    }
}