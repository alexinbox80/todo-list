
git init  
git checkout -b dev  
git remote add origin git@github.com:alexinbox80/todo-list.git  
git fetch origin dev  
git pull origin dev  

composer install

создать .env  
с параметрами  
DB_CONNECTION=pgsql  
DB_HOST=pgsql  
DB_PORT=5432  
DB_DATABASE=todo_list  
DB_USERNAME=sail  
DB_PASSWORD=password  

./vendor/bin/sail artisan key:generate
./vendor/bin/sail up -d  
./vendor/bin/sail artisan migrate --seed  
./vendor/bin/sail artisan passport:install  
