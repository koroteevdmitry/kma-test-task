<?php

    namespace console\controllers;

    use backend\components\notification\Notifier;
    use backend\models\Notification;
    use Exception;
    use yii\data\ActiveDataProvider;
    use yii\console\Controller;

    class CronNotificationController extends Controller
    {

        public function actionIndex(): void
        {
            echo 'cron notification' . PHP_EOL;
            $this->send();
        }

        protected function send(): void
        {
            $query = Notification::find()->where(['status' => Notification::STATUS_WAITING]);
            $dataProvider = new ActiveDataProvider(['query' => $query]);

            $notifications = $dataProvider->getModels();
            foreach ($notifications as $notification) {
                #note need to use chunk for large data

                $notification->send_at = date('Y-m-d H:i:s');
                try{
                    $notifier = new Notifier($notification);
                    $notifier->send();
                    $notification->status = Notification::STATUS_SEND;
                } catch (Exception $e) {
                    # "write" to log
                    echo $e->getMessage();
                    $notification->status = Notification::STATUS_ERROR;

                }
                $notification->save();
            }
        }
    }