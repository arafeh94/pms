<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */


use app\components\ModalForm;


echo ModalForm::widget([
    'formPath' => '@app/views/project/_form',
    'title' => 'Project',
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Projects') ?>
