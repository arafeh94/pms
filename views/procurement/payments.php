<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

/* @var $procurement_id int */

use yii\bootstrap\Html;

?>

<style>
    #payment-grid .summary {
        display: none
    }
</style>

<?= \app\components\GridViewBuilder::render($provider, 'Procurement Payments', [
    'id' => 'payment-grid',
    'panel' => [],
    'showPageSummary' => true
]) ?>


<div style="margin-top: 8px;width: 100%;text-align: right">
    <?= Html::a('<i class="glyphicon glyphicon-plus">ADD</i>', Yii::$app->urlManager->createUrl(['procurement/add-payment', 'id' => $procurement_id]), ['type' => 'button', 'title' => Yii::t('app', "Add"), 'class' => 'btn btn-success']) ?>
</div>
