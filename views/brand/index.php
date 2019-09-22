<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget([
    'formPath' => '@app/views/brand/_form',
    'title' => 'Brand'
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Brands') ?>
