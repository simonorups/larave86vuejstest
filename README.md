
NOTE: This documentation assumes you have composer, docker, php, curl already installed.

### 1. Clone your repository

```git clone https://github.com/simonorups/larave86vuejstest```

### 2. Change directory into the newly created app/project.

```cd larave86vuejstest```

### 3. Install all required dependencies

```
sudo docker start
composer install --ignore-platform-reqs
```

NOTE: This may take a while if this is the first time installing this as a container.

### 4. Set the proper permissions to the project files.

```sudo chown -R $USER: .```


### 5. Create a database to be used by this project by running these commands below

```
mysql -u root -p
create database laravel8vuetest;
exit
```

### 6. Copy .env File 

```cp .env.example.simon .env```

### 7. Make your configurations in the .env

Set your database connection by changing these constants to your prefered 
```
DB_DATABASE=laravel8vuetest
DB_USERNAME=root
DB_PASSWORD=

```

### 8. Generate APP_KEY Key.

```sail artisan key:generate```

### 9. Run migrations

```sail artisan migrate:fresh```

### 10. Optimize cache

```sail artisan optimize:clear```

### 11. Run the servers with Sail 

```./vendor/bin/sail up or sail up -d``` to have the containers run in the background

### 12. Run your app/project

You can now open your application with your browser: http://localhost:8000
