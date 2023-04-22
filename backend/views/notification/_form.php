<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use \backend\models\Notification;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'text')  ?>
<?= $form->field($model, 'integrator')->dropDownList(
        Notification::getIntegratorList(), ['prompt' => 'Выберите интегратора']
    )
?>

<?= Html::submitButton(
    $model->isNewRecord ? 'Создать' : 'Обновить',
    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top:10px']) ?>

<?php ActiveForm::end(); ?>