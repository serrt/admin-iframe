# admin-iframe
Laravel + AdminlLte + Iframe

## 初始化

- `php: ^7.1.3,`
- `composer`

1. `composer install`
2. 复制`.env.example`文件为`.env`
3. `php artisan key:generate`
4. 修改`.env`中的`APP_URL`为虚拟主机中配置的域名, 并配置数据库连接
5. `php artisan migrate --seed` 数据库迁移和填充

