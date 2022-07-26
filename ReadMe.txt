lexik/jwt-authentication-bundle with Symfony 4.4

Installation
-------------------------------------------------------------------
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console lexik:jwt:generate-keypair
symfony server:start

Test
-------------------------------------------------------------------
Query :

*GET user Token(valid for 24 hours) :

curl --location --request POST 'localhost:8000/api/login_check' --header 'Content-Type: application/json' --data-raw '{"username":"user","password":"f56f5h4f6g5h4f56df5gh4"}'

*GET admin Token(valid for 24 hours) :

curl --location --request POST 'localhost:8000/api/login_check' --header 'Content-Type: application/json' --data-raw '{"username":"admin","password":"f56f5h4f6g5h4f56df5gh4_admin"}'

Notes
-------------------------------------------------------------------
After every entity creation or modification, use this command :
symfony console make:migration & bin/console doctrine:migrations:migrate & symfony console doctrine:schema:update --force

After update fixtures, use this command :
php bin/console doctrine:fixtures:load

JSON Collection for Postman
-------------------------------------------------------------------
https://www.postman.com/collections/880b957ed4b9cdded6bf
