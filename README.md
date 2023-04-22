Задача на Yii

Сделать CRUD с оповещениями, которые можно слать в два интегратора, например sms и telegram. Модель оповещения – текст сообщения, выбор интегратора, статус (ожидание,отправлено,ошибка), дата создания, дата отправки(ошибки). Отправку сообщения сделать либо на job, либо на консольной команде (запуск кроном). Саму интеграцию с telegram и sms писать не нужно, просто функция send() которая возвращает true.

**For run app, you need to run command:**

`cat env.example > .env`

`php init` for init yii2 app

`docker-compose up -d`

`docker exec -it kma-test-task_backend_1 bash` for enter to container

`composer install` for install dependencies

`yii migrate` for run migrations

**App will be available on http://0.0.0.0:8088/**

for send all messages you need to run command inside container:

`yii cron-notification`
**This command will be run every hour**
