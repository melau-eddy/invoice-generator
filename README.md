#Laravel Practice

**Requirements**
1. PHP 8.0.8
2. Composer version 2.1.3
3. node.js v12.18.2

**Installation**
- To clone it on your local machine
>git clone https://github.com/Sushmi-pal/laravelnew.git

- Switch to the repo folder
>cd laravelnew

- Install all the dependencies using composer
>composer install

- Copy .env.example file and make the required configuration changes in the .env file
>cp .env.example .env

- Generate a new application key
>php artisan key:generate

**Run**
- It's recommended to have a clean database before seeding
>php artisan migrate:fresh

- Run the database seeder
>php artisan db:seed

- Start the local development server
>php artisan serve
