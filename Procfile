release: php bin/console doctrine:schema:update --force  && php bin/console doctrine:fixtures:load --env=prod --purge-with-truncate
web: heroku-php-apache2 public/
