<?php

    use yii\grid\ActionColumn;
    use yii\grid\SerialColumn;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use \backend\models\Notification;
?>

<style>
    table th,td{
        padding: 10px;
    }
</style>

<?= Html::a('Создать', ['notification/create'], ['class' => 'btn btn-success']) ?>
<?=
    GridView::widget([
        'dataProvider' => $dataProvider, 'columns' => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'Текст сообщения',
                'value' => 'text',
            ],
            [
                 'attribute' => "Cтатус",
                 'value' => static function ($model) {
                     return Notification::getStatus($model->status);
                 }
            ],
            [
                'attribute' => "Интегратор",
                'value' => static function ($model) {
                    return Notification::getIntegrator($model->integrator);
                }
            ],
            [
                'attribute' => 'Дата создания',
                'value' => 'created_at',
            ],
            [
                'attribute' => 'Дата отправки',
                'value' => 'send_at',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => static function ($url, $model) {
                        return $model->status === Notification::STATUS_WAITING ? Html::a('Редактировать', ['notification/edit', 'id' => $model->id]) : '';
                    },
                    'delete' => static function ($url, $model) {
                        return $model->send_at !== null ? '' : Html::a('Удалить', ['notification/delete', 'id' => $model->id]);
                    },
                ],
            ]
         ]
     ])
    ?>