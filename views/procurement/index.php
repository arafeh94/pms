<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalController;
use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/procurement/_form', 'title' => 'Procurement']);

echo ModalController::widget(['title' => 'Payments', 'size' => 'modal-lg']);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Procurements') ?>

