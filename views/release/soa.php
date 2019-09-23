<?php

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/22/2019
 * Time: 2:15 PM
 */

use app\components\extensions\Search;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\components\extensions\Search */
/* @var $payments \app\models\ProjectPayment[]|array|\yii\db\ActiveRecord[] */
/* @var $project \app\models\Project|array|bool|null|\yii\db\ActiveRecord */
?>


<?php $form = ActiveForm::begin(['id' => 'form', 'method' => 'get']) ?>
<?= $form->field($model, 'project_id')->label('Select Project')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->active()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => '', 'onchange' => '$("#form").submit()'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
<?php ActiveForm::end(); ?>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $payments]),
    'columns' => ['due_amount', ['attribute' => 'date_payment', 'format' => 'date'], 'amount', 'method'],
]) ?>
<div style="width: 100%;text-align: right; margin-top: 12px">
    <?= \yii\bootstrap\Html::a('Print', ['release/print-soa'], ['class' => 'btn btn-danger', 'target' => "_blank", 'onclick' => 'return $("#search-project_id").val() !== ""']) ?>
</div>
