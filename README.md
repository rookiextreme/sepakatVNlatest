# **SPAKAT**

## Installation 
1. Clone repository
   ```
    $ git clone git@gitlab.com:cubixi1/spakat.git
   ```

2. Run composer 
    ```
     $ composer install
    ```

3. Create .env file
   ```
    $ cp .env.example .env
    $ php artisan key:generate
   ```

4. Setup database connection inside .env filer (staging db)
   ```
    DB_CONNECTION=mysql
    DB_HOST=data-staging.cubixi.com
    DB_PORT=3306
    DB_DATABASE=spakat2
    DB_USERNAME=cubixidev
    DB_PASSWORD=Cub!x!Success2021
   ``` 

   ```
   #pgsql
    DB_CONNECTION=pgsql
    DB_HOST=data-staging.cubixi.com
    DB_PORT=5432
    DB_DATABASE=spakatdb
    DB_USERNAME=cubixi
    DB_PASSWORD=cub1x1stg01
   ```

   ```
    MAIL_MAILER=smtp
    MAIL_DRIVER=mailjet
    MAIL_HOST=in-v3.mailjet.com
    MAIL_PORT=587
    MAIL_USERNAME=772992b6c17edeb4052ffeca92032dd0
    MAIL_PASSWORD=b9c4f9e90b87615d843253751d935ced
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=irina-noreply@cubixi.com
    MAIL_FROM_NAME="${APP_NAME}"
   ```

   ```
   --DROP SCHEMA identifiers CASCADE;
CREATE SCHEMA identifiers;

--DROP SCHEMA kenderaans CASCADE;
CREATE SCHEMA kenderaans;

--DROP SCHEMA locations CASCADE;
CREATE SCHEMA locations;	

--DROP SCHEMA "public" CASCADE;
-- CREATE SCHEMA "public";

--DROP SCHEMA saman CASCADE;
CREATE SCHEMA saman;

--DROP SCHEMA users CASCADE;
CREATE SCHEMA users;

--DROP SCHEMA vehicles CASCADE;
CREATE SCHEMA vehicles;

--DROP SCHEMA fleet CASCADE;
CREATE SCHEMA fleet;

--DROP SCHEMA logistic CASCADE;
CREATE SCHEMA logistic;

--DROP SCHEMA maintenance CASCADE;
CREATE SCHEMA maintenance;

--DROP SCHEMA assessment CASCADE;
CREATE SCHEMA assessment;

--DROP SCHEMA audit CASCADE;
CREATE SCHEMA audit;

   ```

5. Migrate and seed database
   ```
    $ php artisan migrate
    $ php artisan db:seed 

   ```

6. If change any php .ini
   ```
   - Centos
      > use this command-line `service php-fpm restart` to restart everything

   ```
___
## Packages

1. [livewire/livewire](https://laravel-livewire.com/docs/2.x/quickstart)
2. [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v4/installation-laravel)
