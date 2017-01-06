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



持续集成
----
使用某个平台(阿里云CRP或者其他)的持续集成。有几个路径:
1. 部署路径,比如:/path/openadm.com/deploy/ ,持续集成引擎会把代码包(package.tgz)推送到这个目录
2. 部署后执行脚本:/path/openadm.com/deploy.sh ,当前openadm-yii2下面的deploy.sh,需要提前放到/path/openadm.com/下面。
3. 此时可以执行部署操作。
4. deploy工作,主要就是解压deploy/pacage.tgz,放到openadm.com/src/下面
5. 配置域名到目录的访问:www.openadm.com 指向 /path/openadm.com/src/web/
6. 低配置的vps或者ecs,composer安装过程可能出现内存不够用,具体查看持续集成引擎的报错,如遇到错误可以参加:[Composer内存错误](https://getcomposer.org/doc/articles/troubleshooting.md#proc-open-fork-failed-errors)


界面
----

![插件管理](screen1.png)
![管理员管理](screen2.png)
![角色管理](screen3.png)
![路由列表](screen4.png)
