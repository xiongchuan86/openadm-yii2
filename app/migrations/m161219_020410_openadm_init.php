<?php

use yii\db\Migration;

class m161219_020410_openadm_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable("{{%system_config}}", [
            'id' => $this->primaryKey(11),
            'cfg_name' => $this->string(128)->notNull()->comment('配置名称'),
            'cfg_value' => $this->text()->comment('配置值'),
            'cfg_order' => $this->integer(11)->defaultValue(0)->comment('排序'),
            'cfg_pid' => $this->integer(11)->defaultValue(0)->comment('父ID'),
            'ctime' => $this->integer(11)->defaultValue(0)->comment('创建时间'),
            'cfg_type' => "set('SYSTEM','USER','ROUTE','PLUGIN') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:系统配置,USER:用户配置,ROUTE:路由,PLUGIN:插件'",
            'cfg_status' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 0 不显示'",
            'cfg_comment' => $this->string(255)->comment('配置说明'),
        ], $tableOptions);

        //索引
        $this->createIndex('{{%cfg_name}}', '{{%system_config}}', 'cfg_name', false);
        $this->createIndex('{{%cfg_pid}}', '{{%system_config}}', 'cfg_pid', false);
        $this->createIndex('{{%cfg_type}}', '{{%system_config}}', 'cfg_type', false);

        $columns = ['id','cfg_name', 'cfg_value', 'cfg_order','cfg_pid','ctime','cfg_type','cfg_status','cfg_comment'];
        $ctime = time();
        $this->batchInsert('{{%system_config}}', $columns, [
            [1,'MENU', '{"url":"#","icon":"fa fa-cogs"}', 50, 0, $ctime, 'USER', 1, '系统'],
            [2,'MENU', '{"url":"#","icon":"fa fa-cogs"}', 50, 1, $ctime, 'USER', 1, '系统设置'],
            [3,'MENU', '{"url":"#","icon":"fa fa-unlock-alt"}', 51, 1,$ctime , 'USER', 1, '权限管理'],
            [4,'MENU', '{"url":"/admin/dashboard/main","icon":"fa fa-dashboard"}', 0, 1, $ctime, 'USER', 1, '控制面板'],
            [5,'MENU', '{"url":"/admin/plugin-manager/local/all"}', 0, 2, $ctime, 'USER', 1, '插件管理'],
            [6,'MENU', '{"url":"/user/admin"}', 0, 2, $ctime, 'USER', 1, '用户管理'],
            [7,'MENU', '{"url":"/rbac/assignment"}', 0, 3, $ctime, 'USER', 1, '授权用户'],
            [8,'MENU', '{"url":"/rbac/role"}', 0, 3, $ctime, 'USER', 1, '角色列表'],
            [9,'MENU', '{"url":"/rbac/route"}', 0, 3, $ctime, 'USER', 1, '路由列表'],
            //第12条路由很重要,删除后不能正确访问插件管理功能
            [10,'PLUGINMANAGER_ROUTE', '{"admin/plugin-manager/<a:\w+>/<tab:\w+>":"admin/plugin-manager/<a>"}', 0, 0, $ctime, 'ROUTE', 1, '插件管理路由']
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%system_config}}');
    }
}
