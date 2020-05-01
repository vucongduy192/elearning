## Custom setup

1. Set up .env Laravel

    Make sure that env.DB_HOST is your db service name in docker

    ```bash
    docker-compose exec app cp .env.example .env
    docker-compose exec app nano .env
    ```

2. Set up mysql user + database

    Use MYSQL_ROOT_PASSWORD in docker-compose.yml file to login mysql in db container.

    ```bash
    docker-compose exec db mysql -u root -p
    ```

    Then, check db's host to grant new user. In my enviroment, host is '%'

    ```bash
    select Host, USER from mysql.user;
    ```

    Create new db and grant all privilege to your custom user

    ```bash
    CREATE DATABASE elearning;
    CREATE USER 'duyvc'@'%' IDENTIFIED BY 'duy123';
    GRANT ALL PRIVILEGES ON elearning.* TO 'duyvc'@'%';
    FLUSH PRIVILEGES;
    ```

3. Apply all setup to current laravel project
```bash 
    docker-compose exec app composer install 
    docker-compose exec app npm install 
    docker-compose exec app php artisan key:generate 
    docker-compose exec app php artisan migrate
```
Finally because in this project using VueJS, let run final bash to listening and
re-compile Vue Component if have any change!

```bash
docker-compose exec app npm run watch
```

Don't forget change permission for storage image folder
```bash
php artisan storage:link
sudo chmod 775 storage/app/public/
```

Storage link to public folder: remember that link must be created when logged in docker container