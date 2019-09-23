<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget([
    'formPath' => '@app/views/invoice-item/_form',
    'title' => 'Item'
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Items') ?>
