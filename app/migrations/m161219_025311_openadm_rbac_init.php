<?php

use yii2mod\rbac\migrations\Migration;

class m161219_025311_openadm_rbac_init extends Migration
{
    public function safeUp()
    {
        $this->createRole('Admin', '超级管理员');
        $this->createRole('User', '普通用户');

        $this->createPermission('/*');
        $this->createPermission('/admin/dashboard/*');
        $this->createPermission('/debug/*');
        $this->createPermission('/gii/*');
        $this->createPermission('/admin/plugin-manager/*');
        $this->createPermission('/plugin/*');
        $this->createPermission('/rbac/*');
        $this->createPermission('/site/*');
        $this->createPermission('/user/*');
        $this->createPermission('/user/default/*');

        $this->addChild('Admin', '/*');
        $this->addChild('Admin', '/admin/dashboard/*');
        $this->addChild('Admin', '/debug/*');
        $this->addChild('Admin', '/gii/*');
        $this->addChild('Admin', '/admin/plugin-manager/*');
        $this->addChild('Admin', '/plugin/*');
        $this->addChild('Admin', '/rbac/*');
        $this->addChild('Admin', '/site/*');
        $this->addChild('Admin', '/user/*');


        $this->addChild('User', '/admin/dashboard/*');
        $this->addChild('User', '/site/*');
        $this->addChild('User', '/plugin/*');
        $this->addChild('User', '/user/default/*');


        $this->assign('Admin', 1);
    }

    public function safeDown()
    {
//        $this->removeRole('Admin');
//        $this->removeRole('User');
//
//        $this->removePermission('/*');
//        $this->removePermission('/dashboard/*');
//        $this->removePermission('/debug/*');
//        $this->removePermission('/gii/*');
//        $this->removePermission('/plugin/*');
//        $this->removePermission('/plugin-manager/*');
//        $this->removePermission('/rbac/*');
//        $this->removePermission('/site/*');
//        $this->removePermission('/user/*');
//        $this->removePermission('/user/default/*');

    }
}