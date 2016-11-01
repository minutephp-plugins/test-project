<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MemberInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_member_banners
        $table = $this->table('m_member_banners', array('id' => 'member_banner_id'));
        $table
            ->addColumn('created_at', 'datetime', array('null' => true))
            ->addColumn('starts_at', 'datetime', array('null' => true))
            ->addColumn('expires_at', 'datetime', array('null' => true))
            ->addColumn('name', 'string', array('limit' => 255))
            ->addColumn('html_safe', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('visibility', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('repeat', 'enum', array('null' => true, 'default' => 'true', 'values' => array('true','false')))
            ->addIndex(array('name'), array('unique' => true))
            ->create();


        // Migration for table m_member_notices
        $table = $this->table('m_member_notices', array('id' => 'member_notice_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('title', 'string', array('limit' => 255))
            ->addColumn('icon', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('description', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('links_json', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('class', 'enum', array('null' => true, 'default' => 'default', 'values' => array('default','success','danger','warning','info')))
            ->addColumn('seen', 'enum', array('null' => true, 'default' => 'false', 'values' => array('false','true')))
            ->addIndex(array('user_id', 'created_at'), array())
            ->addIndex(array('user_id', 'seen'), array())
            ->create();


        // Migration for table m_notices
        $table = $this->table('m_notices', array('id' => 'notice_id'));
        $table
            ->addColumn('name', 'string', array('limit' => 255))
            ->addColumn('title', 'string', array('limit' => 255))
            ->addColumn('icon', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('description', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('links_json', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('class', 'enum', array('default' => 'default', 'values' => array('default','success','danger','warning','info')))
            ->addColumn('plugin', 'string', array('null' => true, 'limit' => 50))
            ->addIndex(array('name'), array('unique' => true))
            ->create();


    }
}