# install laravel
composer create-project --prefer-dist laravel/laravel:^10.0 crm

cd crm

nano .env

# install sail
composer require laravel/sail --dev

# change .env 

DB_DATABASE=crm

DB_USERNAME=root

DB_PASSWORD=password

# install sail
php artisan sail:install


./vendor/bin sail up -d

# all later commands will work with sail

./vendor/bin/sail php --version

./vendor/bin/sail artisan --version

./vendor/bin/sail composer --version

./vendor/bin/sail npm --version

....

./vendor/bin/sail composer require laravel/breeze --dev

./vendor/bin/sail php artisan breeze:install vue

./vendor/bin/sail npm install vue@latest vue-router@4

./vendor/bin/sail npm install

./vendor/bin/sail npm run dev

# generate a new application key:
./vendor/bin/sail artisan key:generate

# create a symbolic link to the storage directory:
./vendor/bin/sail artisan storage:link

# start migrations
./vendor/bin/sail artisan migrate


