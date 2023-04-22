<?php

    namespace backend\components\notification;

    use backend\models\Notification;
    use yii\base\Component;
    use yii\base\InvalidConfigException;

    class Notifier extends Component
    {
        private Notification $notification;
        public NotificatorInterface $notificator;

        public function __construct(Notification $notification, $config = [])
        {
            $this->notification = $notification;
            parent::__construct($config);
        }

        /**
         * @return void
         * @throws InvalidConfigException
         * @throws \Exception
         */
        public function send(): void
        {
            $this->notificator = match ($this->notification->integrator) {
                Notification::INTEGRATOR_TELEGRAM => \Yii::createObject(TelegramNotificator::class),
                Notification::INTEGRATOR_EMAIL => \Yii::createObject(EmailNotificator::class),
                default => throw new \Exception('Notificator not found'),
            };
            $this->notificator->send($this->notification->text);
        }

    }