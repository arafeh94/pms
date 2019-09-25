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
/* @var $project \app\models\Project */
?>

<?php $form = ActiveForm::begin(['id' => 'form', 'method' => 'get']) ?>
<?= $form->field($model, 'project_id')->label('Select Project')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->active()->open()->all(), 'id', 'name'),
    'options' => ['placeholder' => '', 'onchange' => '$("#form").submit()'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
<?php ActiveForm::end(); ?>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $project ? [$project] : null]),
    'columns' => ['po_number', 'terms', ['attribute' => 'date_end'], 'order_value'],
]) ?>
<div style="width: 100%;text-align: right; margin-top: 12px">
    <?= \yii\bootstrap\Html::a('Print', ['release/print-acceptance'], ['class' => 'btn btn-danger', 'target' => "_blank", 'onclick' => 'return $("#search-project_id").val() !== ""']) ?>
</div>