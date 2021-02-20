release: php bin/console doctrine:migrations:migrate && composer require --prod orm-fixtures &&php bin/console doctrine:fixtures:load
web: heroku-php-apache2 public/
