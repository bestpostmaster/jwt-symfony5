lexik/jwt-authentication-bundle with Symfony 4.4

Installation
-------------------------------------------------------------------
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console lexik:jwt:generate-keypair
symfony server:start

Test
-------------------------------------------------------------------
Query :

curl --location --request POST 'localhost:8000/api/login_check' \
--header 'Content-Type: application/json' \
--data-raw '{"username":"user","password":"fd54gh5fg4h5fh4f5g54hf5"}

Response :

{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTgwNDU1OTgsImV4cCI6MTY1ODA0OTE5OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.UrqTf2qlwAl7ipv6xbSE-IzBp8VHSY_DO8KqeAJmJLuJznL8KtVSDDJ2yR7YUsRUx7UI3c3sB5vvfwRYfdtbIWpr_cB2YZ7gxxKVzbQbHy2XXLkS1Bj5Jr6Ug-B_f5wCyZYjnLdKpbzPQ7Or2Uqyk49ISpm1u2-MY59wpQZu1bjOG93GsmEwctL5wmTsNeTEhuWMhP8u4k3hf2HjUaQP4quOCQCKGVp1XdAtEoeYVN85hcKIdhFfGhXaupMa_pVd4gQsiu-nFw60VYW_-YlVeHWfvv21U-WAYvGwiJDBl3LvxBYB2lKPtJTZEbUrJ2syUIgGVho70ngWsmpba2TfTQ"
}


