release: php bin/console doctrine:migrations:migrate  && php bin/console doctrine:fixtures:load && php bin/console doctrine:schema:update --force
web: heroku-php-apache2 public/
