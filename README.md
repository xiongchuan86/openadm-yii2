YetCMS
======
>YetCMS是一个基于Yii2的快速开发框架，集成了用户和插件系统，可以非常方便的开发新的功能。

安装
----
1. git clone https://github.com/xiongchuan86/YetCMS.git
2. composer update
3. 配置数据库连接，YetCMS/app/config/db.php
4. yii migrate
5. Apache 建立虚拟机,域名http://www.yetcms.com绑定到 YetCMS
6. http://www.yetcms.com
7. 默认的管理员用户名和密码，admin@yetcms.com,123456
8. 注册需要邮箱验证，配置config.php里面的mailer
