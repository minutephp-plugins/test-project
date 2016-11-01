<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ProjectInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_projects
        $table = $this->table('m_projects', array('id' => 'project_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('updated_at', 'datetime', array())
            ->addColumn('title', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('title_slug', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('data_json', 'text', array('limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('public', 'enum', array('null' => true, 'default' => 'true', 'values' => array('true','false')))
            ->addIndex(array('title_slug'), array('unique' => true))
            ->create();


    }
}