<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model InvoiceItem */


use app\models\InvoiceItem;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new InvoiceItem();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['invoice-item/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'project_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->active()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['project/index'], 'Add Project')
]); ?>

<?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Brand::find()->active()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['brand/index'], 'Add Project')
]); ?>
<?= $form->field($model, 'code')->textInput() ?>
<?= $form->field($model, 'old_code')->textInput() ?>
<?= $form->field($model, 'description')->textInput() ?>
<?= $form->field($model, 'quantity')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'price_ttl')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'orc_ref')->textInput() ?>
<?= $form->field($model, 'se_ref')->textInput() ?>
<?= $form->field($model, 'pft')->textInput() ?>
<?= $form->field($model, 'fob_cost')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'fob_ttl')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'currency')->widget(Select2::className(), ['data' => ['usd', 'eur', 'aed', 'qar', 'gbp', 'omr', 'aud'], 'hideSearch' => true]) ?>
<?= $form->field($model, 'orc_cost')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'orc_ttl')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'order_status')->widget(Select2::className(), ['data' => ['in progress', 'completed', 'waiting', 'canceled'], 'hideSearch' => true]) ?>

<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>
