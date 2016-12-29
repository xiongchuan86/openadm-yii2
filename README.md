OpenAdm
======
>OpenAdm是一个基于Yii2的后台开源骨架，集成了用户和插件系统,使用主题功能,默认使用AdminLTE2的模板的主题,可以非常方便的开发新的功能。

安装
----
1. git clone https://code.aliyun.com/xiongchuan86/openadmin-yii2.git
2. composer install
3. 创建数据库openadm,如果不使用默认的数据库名,修改environments/dev/app/config/db.php
3. ./init #安装
4. ./yii migrate #数据库初始化
5. 域名admin.yii2.openadm.com指向web目录
6. http://admin.yii2.openadm.com
7. 默认的管理员用户名和密码，admin,admin
8. 如果需要使用前台用户功能,请配置environments/dev/app/config/main-local.php里面的mailer,然后再./init 安装


界面
----

![插件管理](screen1.png)
![管理员管理](screen2.png)
![角色管理](screen3.png)
![路由列表](screen4.png)
