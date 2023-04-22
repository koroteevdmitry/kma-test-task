<?php

    namespace backend\components\notification;

    use yii\base\Component;

    class TelegramNotificator extends Component implements NotificatorInterface
    {
        /**
         * @param string $massage
         * @return bool
         */
        public function send(string $massage): bool
        {
            return true;
        }

    }