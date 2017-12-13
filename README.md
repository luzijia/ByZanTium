# ByZanTium
#### a light easy PHP framework

# 如何使用

### 建立项目

```
php <somewhere>/Rigger/rigger_app.php
```

### 项目目录

生成后目录如下：

```
app/
   controller/
        admin/
                AdminController.php
        WelcomeController.php
   models/
   service/
   vendor/
        Composer/
            autoload_composer.php
   views/
        Admin/
        Welcome/
   cli/
        index.php
   config/
        config.dev.php
        config.prod.php
        router.php
   public/
        index.php

```
####执行脚本

sh {somewhere}/deploy/deploy.sh dev
or
sh {somewhere}/deploy/deploy.sh online

### WEB 模式

#### get 参数获取

```
$this->getQuery("page")
```

#### post 参数获取

```
$this->getPost("page")
```

### 路由 模式
##### 设置路由配置文件：


```
vim <somewhere>/config/router.php

路由

  [
     "模式支持正则匹配"=>[Module,Controller,Action]
  ]
  return[
    'Welcome'=>["","WelcomeController","welcome"]

    '/admin/getVideoList/(page)/(\d+)/(cate)/(\d+)/'=>['admin','Admin','getVideoList'],
    ]
```


### CLI 模式

```
php {somewhere}/cli/index.php  Controller Action 'x=1&b=2'

php {somewhere}/cli/index.php  mydb dotask 'x=1&b=2'
```

### 模版
使用开源模版blade

```
$this->assign("data",$data);
$this->display('Admin.admin');
```

### 支持Composer
修改项目里的vendor/composer/autoload_composer.php
