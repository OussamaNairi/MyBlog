release: php bin/console doctrine:migrations:migrate  && php bin/console doctrine:fixtures:load --env=prod --append
web: heroku-php-apache2 public/
