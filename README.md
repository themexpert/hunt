## Hunt

Build a better products with your users, customers, and internal teams by capturing product feedback and prioritize them intelligently.


## Pre Requirement

- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- [Composer](https://getcomposer.org/download/)
- Database ( MySql or PostgreSQL )

## Optional Pre Requirement

- [Beanstalkd](http://kr.github.io/beanstalkd/)


## Installation Process

**Clone hunt on your machine then follow all steps one by one.**

1. Copy .env.example to .env
2. Open .env and setup your APP_NAME and FROM_EMAIL
3. Setup your DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD in the .env file
4. After that, setup your MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD in the .env file
5. Copy config/developer.example.php file to config/developer.php and add your developer email address ( The email address you will set in the developer.php file, they will get extra power in the Hunt such as products creating, deleting and many more ).
6. Set bootstrap and storage directory permission to 755
7. Open your terminal and run ```composer install``` from hunt root directory ( to install Hunt dependencies )
8. Run ```php artisan migrate```
9. Finally, run ```php artisan passport:install```

**There are two optional setup process, you may want ( not mandatory )**

- If you want Gmail login support
    1. Goto [Google Console](https://console.developers.google.com/)
    2. Create your own API key ( use your-domain.com/auth/google/callback as Authorized redirect URIs )
    3. Enable Google+ API
    4. Setup your API credential GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT in the .env file

- If you want Beanstalk as your Queue Driver
    1. Install [Beanstalkd](http://kr.github.io/beanstalkd/)
    2. Set QUEUE_DRIVER as beanstalkd in the .env file.


## License

This package is licensed under the [MIT License](https://github.com/themexpert/hunt/blob/master/LICENSE)

