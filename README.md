# Install guide

## create symlink for nginx config

`ln -s /var/www/yii2-skeleton/data/nginx/prod.conf /etc/nginx/sites-enabled/yii2-skeleton.prod.conf`

## create local config, then edit it

`cp config/local.sample.php config/local.php`

## set permissions

`chmod -R 0777 runtime/ web/assets`
