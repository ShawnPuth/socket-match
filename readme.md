## About SocketMatch

基于WebSocket的多人在线匹配demo,可用于头脑王者等小游戏

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

step1:composer update

step2:php artisan migrate:fresh --seed

## Workerman
step3:服务器开放端口：1236,7272

step4:./resources/views/match/index.blade.php 修改监听的socket IP地址
## GatewayWorker
step5:启动socket：php artisan gateway-worker:server start --daemon

step6: 访问/login  登录 测试账号 13012340001 13012340002 13012340003  13012340004
## Redis

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
