<?php

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 2:49 PM
 */

use app\components\extensions\Search;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model Search */
/* @var $invoices \app\models\InvoiceItem[] */
/* @var $project \app\models\Project */
/* @var $inv_ref int */
?>

<?php $form = ActiveForm::begin(['id' => 'form', 'method' => 'get']) ?>
<?= $form->field($model, 'recovery')->label('Payable %')->textInput(['type' => 'number', 'onchange' => '$("#form").submit()', 'value' => '100']) ?>

<?= $form->field($model, 'project_id')->label('Select Project')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->active()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => '', 'onchange' => '$("#form").submit()'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?php ActiveForm::end(); ?>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $invoices]),
    'columns' => ['description', 'brand.name', 'quantity', 'price'],
]) ?>


<div style="width: 100%;text-align: right; margin-top: 12px">
    <span class="text-info center-block" style="text-align: left;font-size: 11pt">Print With Invoice Reference: <b><?= $inv_ref ?></b></span>
    <?= \yii\bootstrap\Html::a('Print', ['release/print-invoice'], ['class' => 'btn btn-danger', 'target' => "_blank", 'onclick' => 'return $("#search-project_id").val() !== ""']) ?>
</div>
