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
            'cfg_type' => "set('SYSTEM','USER','ROUTE') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:系统配置,USER:用户配置,ROUTE:路由'",
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
            [1,'MAINMENU', '#', 501, 0,$ctime , 'USER', 1, '权限管理'],
            [2,'MAINMENU', '#', 500, 0, $ctime, 'USER', 1, '系统设置'],
            [3,'MAINMENU', '/dashboard/main', 0, 0, $ctime, 'USER', 1, '控制面板'],
            [4,'ICONS', '系统设置', 0, 0, $ctime, 'USER', 1, 'fa-cogs'],
            [5,'ICONS', '控制面板', 0, 0, $ctime, 'USER', 1, 'fa-dashboard'],
            [6,'SUBMENU', '/plugin-manager/local', 0, 2, $ctime, 'USER', 1, '插件管理'],
            [7,'THIRDMENU', '/plugin-manager/local/?tab=all', 0, 6, $ctime, 'USER', 1, '全部'],
            [8,'THIRDMENU', '/plugin-manager/local/?tab=setuped', 1, 6, $ctime, 'USER', 1, '已安装'],
            [9,'THIRDMENU', '/plugin-manager/local/?tab=new', 2, 6, $ctime, 'USER', 1, '未安装'],
            [10,'SUBMENU', '/user/admin', 0, 2, $ctime, 'USER', 1, '管理员列表'],
            [11,'SUBMENU', '/rbac/assignment', 0, 1, $ctime, 'USER', 1, '授权用户'],
            [12,'SUBMENU', '/rbac/role', 0, 1, $ctime, 'USER', 1, '角色列表'],
            [13,'ICONS', '权限管理', 0, 0, $ctime, 'USER', 1, 'fa-unlock-alt'],
            [14,'SUBMENU', '/rbac/route', 0, 1, $ctime, 'USER', 1, '路由列表'],
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%system_config}}');
    }
}
