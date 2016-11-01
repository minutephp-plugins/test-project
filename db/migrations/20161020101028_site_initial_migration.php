<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class SiteInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_configs
        $table = $this->table('m_configs', array('id' => 'config_id'));
        $table
            ->addColumn('type', 'string', array('limit' => 20))
            ->addColumn('data_json', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addIndex(array('type'), array('unique' => true))
            ->create();


        // Migration for table m_event_names
        $table = $this->table('m_event_names', array('id' => 'event_name_id'));
        $table
            ->addColumn('event_name', 'string', array('limit' => 255))
            ->addIndex(array('event_name'), array('unique' => true))
            ->create();


        // Migration for table m_events
        $table = $this->table('m_events', array('id' => 'event_id'));
        $table
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('handler', 'string', array('limit' => 100))
            ->addColumn('data', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('priority', 'integer', array('null' => true, 'default' => '0', 'limit' => 11))
            ->addColumn('comments', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('plugin', 'string', array('null' => true, 'limit' => 50))
            ->addIndex(array('name', 'handler'), array('unique' => true))
            ->create();


        // Migration for table m_user_groups
        $table = $this->table('m_user_groups', array('id' => 'user_group_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('product_cart_id', 'integer', array('null' => true, 'default' => '0', 'limit' => 11))
            ->addColumn('group_name', 'string', array('limit' => 255))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('updated_at', 'datetime', array())
            ->addColumn('expires_at', 'datetime', array())
            ->addColumn('credits', 'integer', array('limit' => 11))
            ->addColumn('comments', 'string', array('null' => true, 'limit' => 255))
            ->addIndex(array('user_id', 'expires_at', 'credits'), array())
            ->create();


        // Migration for table users
        $table = $this->table('users', array('id' => 'user_id'));
        $table
            ->addColumn('ident', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('updated_at', 'datetime', array())
            ->addColumn('email', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('contact_email', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('password', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('first_name', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('last_name', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('photo_url', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('tz_offset', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('ip_addr', 'string', array('null' => true, 'limit' => 15))
            ->addColumn('http_campaign', 'string', array('null' => true, 'limit' => 50))
            ->addColumn('http_referrer', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('verified', 'enum', array('null' => true, 'default' => 'false', 'values' => array('false','true')))
            ->addIndex(array('ident'), array('unique' => true))
            ->addIndex(array('email'), array('unique' => true))
            ->create();


    }
}