## 关于 ##
这是基于我的后台管理项目LaraAdmin开发的个人博客系统。

## 功能 ##
- 控制台
- 系统管理
 - 用户管理
 - 角色管理
 - 权限管理
 - 菜单管理
 - 系统日志
- 博客
 - 文章
 - 分类
 - 标签

## 安装 ##
下载项目到本地
```
git clone https://github.com/251068550/LaraBlog.git
```
compoer安装
```
cd LaraBlog
composer install
```
> 如果composer install安装很慢，推荐安装国内镜像
> 执行 `composer config -g repo.packagist composer https://packagist.phpcomposer.com`

配置.env文件
```
cp .env.example .env
```
配置数据库
```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
生成APP_KEY
```
php artisan key:generate
```
数据库迁移(记得先创建配置的数据库)
```
php artisan migrate --seed
```
这样项目就部署好了，后台的登录路由是
http://localhost:(端口)/LaraAdmin/public/login
管理员帐号：admin，密码：123456

**Enjoy yourself!**