<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Procurement */


use app\models\Procurement;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use \kartik\date\DatePicker;

if (!isset($model)) $model = new Procurement();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['procurement/update'],
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
<?= $form->field($model, 'supplier_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Supplier::find()->active()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['supplier/index'], 'Add Supplier')
]); ?>
<?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Brand::find()->active()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['brand/index'], 'Add Brand')
]); ?>

<?= $form->field($model, 'value')->textInput(['type' => 'number', 'onchange' => 'updateSe(this)']) ?>
<?= $form->field($model, 'currency')->widget(Select2::className(), ['data' => ['usd', 'eur', 'aed', 'qar', 'gbp', 'omr', 'aud'], 'hideSearch' => true]) ?>
<?= $form->field($model, 'type')->widget(Select2::className(), ['data' => ["SELLABLE", "I-PROC.", "PC."], 'hideSearch' => true]) ?>
<?= $form->field($model, 'terms')->textInput() ?>
<?= $form->field($model, 'se_fctr')->textInput(['type' => 'number', 'onchange' => 'updateSe(this)']) ?>
<?= $form->field($model, 'se_cost')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'pr')->textInput() ?>
<?= $form->field($model, 'po_ref')->textInput() ?>
<?= $form->field($model, 'po_date')->widget(DatePicker::className(), \app\components\Extensions::picker()) ?>
<?= $form->field($model, 'se')->textInput() ?>
<?= $form->field($model, 'se_status')->widget(Select2::className(), ['data' => ['CLOSED', 'OPENED'], 'hideSearch' => true]) ?>
<?= $form->field($model, 'inv_ref')->textInput() ?>

<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>
<script>
    function updateSe(element) {
        let fctr = $('#procurement-se_fctr').val();
        let value = $('#procurement-value').val();
        $('#procurement-se_cost').val(value * fctr);
    }
</script>