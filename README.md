# admin-iframe
Laravel + AdminlLte + Iframe

## 项目要求

- php >= 7.1
- composer
- mysql >= 5.6

## 安装

1. `composer install`
2. 复制`.env.example`文件为`.env`
3. `php artisan key:generate`
4. 修改`.env`中的`APP_URL`为虚拟主机中配置的域名, 并配置数据库连接, 时区参数`TIMEZONE`
```
APP_URL=http://localhost

TIMEZONE=Asia/Chongqing

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin-iframe
DB_USERNAME=homestead
DB_PASSWORD=secret
```
5. `php artisan migrate --seed` 数据库迁移和填充
6. 数据库迁移后, 默认的后台用户`username: admin, password: 123456`, 也可以自己创建后台用户`php artisan generate:admin username password`
7. `bootstrap/cache` 和 `storage/` 两个目录需要配置**读写**权限
8. 本地文件上传 `php artisan storage:link`, 或者手动创建软连`ln -s /path/to/storage/app/public public/storage`

## TODO

### id 加密

[hashids](https://github.com/vinkla/laravel-hashids)

### Excel导出

数据比较多的时候，考虑使用 [队列导出](https://laravel-china.org/docs/laravel/5.6/queues/1395), [Excel-Queue](https://laravel-excel.maatwebsite.nl/3.0/exports/queued.html)

### 配置微信分享

### 后台扫码登陆
