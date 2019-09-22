<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/project-expense/_form', 'title' => 'Project Expense',]);


?>


<?= \app\components\GridViewBuilder::render($provider, 'Projects Expenses') ?>
