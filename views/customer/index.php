<?php
/* @var $this yii\web\View */

/* @var $provider \app\models\providers\CustomerDataProvider */

use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/customer/_form', 'title' => 'Customer',]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Customers') ?>
