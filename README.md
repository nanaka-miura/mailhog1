# お問い合わせフォーム
## 環境構築
Dockerビルド  
1.git clone git@github.com:coachtech-material/laravel-docker-template.git  
2.docker-compose up -d --build  

Lavaral環境構築  
1.docker-compose exec php bash  
2.composer install  
3..env.exampleファイルから.envを作成し、環境変数を変更  
4.php artisan key:generate  
5.php artisan migrate  
6.php artisan db:seed 
7.php artisan test  
8.php artisan storage:link  
9.docker run -d --name mailhog -p 1025:1025 -p 8025:8025 mailhog/mailhog


## 使用技術
・PHP 7.4.9  
・Laravel 8.83.27  
・MySQL 8.0.26  
・nginx 1.21.1  
・MailHog latest  

## ER図
![er](https://github.com/user-attachments/assets/c66d0511-5706-4380-a066-d4a83e72ff3e)

  

### URL
・開発環境：http://localhost/  
・phpMyAdmin：http://localhost:8080/  
・MailHog：http://localhost:8025/
