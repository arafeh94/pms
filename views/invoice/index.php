<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget([
    'formPath' => '@app/views/invoice/_form',
    'title' => 'New Invoice'
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Invoices') ?>
