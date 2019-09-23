<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model \app\models\ProjectPayment */


use app\models\ProjectPayment;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

if (!isset($model)) $model = new ProjectPayment();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['project-payment/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'project_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['project/index'], 'Add Project')
]); ?>


<?= $form->field($model, 'method')->widget(Select2::className(), ['data' => ['PDC 30', 'PDC 60', 'PDC 45', 'PDC 90', 'Cost+5Perc', 'BTT Charges', '30 Days Net', '60 Days Net', '45 Days Net', '90 Days Net', 'Refund'], 'hideSearch' => true]) ?>
<?= $form->field($model, 'amount')->textInput(['type' => 'number', 'onchange' => 'changeDue(this)']) ?>
<?= $form->field($model, 'date_payment')->widget(DatePicker::className(), ['dateFormat' => 'y-M-d', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
<?= $form->field($model, 'crv_ref')->textInput() ?>
<?= $form->field($model, 'inv_value')->textInput(['type' => 'number', 'onchange' => 'changeDue(this)']) ?>
<?= $form->field($model, 'inv_ref')->textInput(['placeholder' => 'Evaluated After Creation', 'disabled' => 'true']) ?>
<?= $form->field($model, 'inv_date')->widget(DatePicker::className(), ['dateFormat' => 'y-M-d', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
<?= $form->field($model, 'due_amount')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'due_date')->widget(DatePicker::className(), ['dateFormat' => 'y-M-d', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>


<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

<script>
    function changeDue(element) {
        let payAmount = $('#projectpayment-amount').val();
        let invAmount = $('#projectpayment-inv_value').val();
        $('#projectpayment-due_amount').val(invAmount - payAmount);
    }
</script>