git pull --rebase
sudo -u www-data php ../cobatApi/app console c:c --env=prod
service php7.0-fpm restart
