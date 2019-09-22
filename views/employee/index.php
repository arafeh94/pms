<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/employee/_form', 'title' => 'New Employee',]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Employees') ?>
