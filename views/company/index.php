<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget([
    'formPath' => '@app/views/company/_form',
    'title' => 'Company'
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Companies') ?>
