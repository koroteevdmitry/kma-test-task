FROM yiisoftware/yii2-php:8.1-apache

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/backend/web|g' /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get -y install cron
RUN touch /var/log/cron.log

# Setup cron job for every hour
RUN (crontab -l ; echo "0 * * * * /usr/local/bin/php /app/yii cron-notification") | crontab

