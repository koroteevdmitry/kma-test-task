<?php

namespace backend\controllers;

use backend\models\Notification;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class NotificationController extends Controller
{
    /**
     * Create
     */
    public function actionCreate(): Response|string
    {
        $model = new Notification();
        if($model->load(Yii::$app->request->post())) {
            try {
                $model->status = Notification::STATUS_WAITING;
                $model->created_at = date('Y-m-d H:i:s');
                $model->send_at = null;
                $model->save();
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', ['model' => $model]);
    }


    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $notification = Notification::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Notification::find(),
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }


    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionEdit($id): Response|string
    {
        $model = Notification::find()->where(['id' => $id])->one();

        // $id not found in database
        if($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // update record
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }


    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = Notification::find()->where(['id' => $id])->one();

        // $id not found in database
        if($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        // delete record
        $model->delete();

        return $this->redirect(['index']);
    }
}
