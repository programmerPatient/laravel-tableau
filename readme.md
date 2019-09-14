#项目的初始化
    
    (1)修改时区

        修改config/app.php文件下的timezone

    (2)下载语言包：laravel-lang

        命令：composer require caouecs/laravel-lang:~3.0

        将语言包文件zh-CN从vendor/caouecs/laravel-lang/src中复制到resources/lang目录下

        修改config/app.php下的locale改为zh-CN

    (3)配置数据库

        创建数据库education,选择字符集utf8_gengeral_ci

        配置数据库的连接：修改根目录下的.env文件修改DB_DATABASE为相应的数据库名称，其它配置根据需要修改

        推荐禁用mysql的严格模式,需要修改config/database.php下的mysql内的strict为false

    (4)删除系统自带的非必要的文件

        删除app/User.php

        删除app/Http/Controllers/Auth目录

        删除databas/migrations目录和database/seeds目录下的全部文件

        删除public下的js和css目录

        删除resources/views下的全部文件

    (5)(可选,开发时可用，线上不能用)安装debugbar工具条，要求php版本大于等于7.0

        命令：composer require barryvdh/laravel-debugbar --dev

##使用datatables插件实现列表的无刷新分页

    Datatables插件是一款基于jquery框架进行开发的无刷新分页插件，其除了分页还有排序搜索等功能

    官网：https://www.datatables.net/

    该分页插件有两种形式，客户端分页方式，服务端分页方式（limit）

    客户端分页，优点是当数据量很少的时候，其速度比较快的，其所有的操作都在客户端完成，但是如果数据量大的话，则加载会很慢。

    服务端分页，优点是数据量大的时候，由于每次都是通过limit限制输出记录，所以其速度基本不受影响，但是如果数据量少的时候则服务器的压力相对较大。

    后期在做datatables分页的时候可以根据数据量来选择是使用客户端还是服务器端   

    *使用步骤*：

        (1)先确保引入jquery之后，再去引入datatables的javascript文件

        (2)需要初始化datatables插件

        (3)【可选】datatables支持一些扩展的配置

#RBAC介绍

    RBAC,Role-Based Access Control,基于角色的访问控制，是一个比较完善的权限访问控制机制。目前有两套权限控制方案，一个是基于用户的权限控制，一套是基于角色的控制权限。

    RBAC在后期的权限维护上是很方便的。

    RBAC权限方式在项目开发的初始阶段就已经有了一个成型标准

    目前在很多大的项目后台，其权限方式都是使用RBAC权限控制方式 

        RBAC方式体现，目前有两种方式，三表RBAC形式、无标RBAC形式。不管三表还是五表，原理一样。

        出现三表（用户表、角色表、权限表）和五表（用户表、用户与角色的关系表、角色表、角色与权限的关系表、权限表）的原因就是设计规范要求（三范式）。

        三表：优点，表少，维护起来数据方便、理解起来也方便；缺点就是不遵循范式要求。

        五表优点遵循范式要求。

##理清RBAC表之间的关系
    
    mananger表内的role_id与role表内的id对应，role表内的auth_ids代表了auth表内的id的集合。用户表manager与权限表没有直接的关系。
