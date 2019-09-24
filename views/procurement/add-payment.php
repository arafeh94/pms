<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/22/2019
 * Time: 2:06 AM
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use \kartik\date\DatePicker;


/** @var $model \app\models\ProcurementPayment */
/** @var $procurement_id int */
/** @var $provider \app\components\extensions\AppDataProvider */

?>


<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ["procurement/add-payment?id=$procurement_id"],
]) ?>
<?= $form->field($model, 'procurement_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'amount')->textInput() ?>
<?= $form->field($model, 'date')->widget(DatePicker::className(), \app\components\Extensions::picker()) ?>

<div class="button-container">
    <?= Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
    <?= Html::button('back', ['class' => 'btn btn-success', 'onclick' => "location.href='" . Yii::$app->urlManager->createUrl(['procurement/index']) . "'"]) ?>
</div>
<?php ActiveForm::end(); ?>

<div style="margin-top: 16px">
    <h3>Payments</h3>
    <?= \app\components\GridViewBuilder::render($provider, 'Procurement Payments', [
        'id' => 'payment-grid',
        'panel' => [],
    ]) ?>
</div>
