<?php

    namespace backend\components\notification;

    interface NotificatorInterface
    {
        /**
         * @param string $massage
         * @return bool
         */
        public function send(string $massage): bool;
    }