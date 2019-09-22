<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/supplier/_form', 'title' => 'Supplier']);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Suppliers') ?>
