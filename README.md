## Simple Demo Chat public

this application is a demo of a dockerized public chat 

### installation

Using the terminal proceed with the next steps

1) Clone this repository

    ``` bash
    $   git clone https://github.com/kujjs/chat-public.git
    ```

2)  Access the project folder and run the docker composer
    ``` bash
    $   cd ./chat-public
    $   docker-compose up -d --build 
    ```
3) Run the next command to finish the installation of the project
    ```bash
    $   docker-compose run --rm composer install --no-interaction --no-dev 
    $   docker-compose run --rm app cp .env.example .env 
    $   docker-compose run --rm app php artisan key:generate 
    $   docker-compose run --rm app php artisan migrate --force --no-interaction
    $   docker-compose run --rm app php artisan passport:install --force --no-interaction 
    
    $   docker-compose up -d
    ```
4) You are ready to access it now from your browser
[localhost:8080](http://localhost:8080).
 
### Uninstall
To uninstall docker-composer you must use the next command
``` bash
$   docker-compose rm -sf 
$   docker volume rm chat-public_mysqldata chat-public_redisdata
```



