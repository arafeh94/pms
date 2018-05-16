<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<?php $form = ActiveForm::begin([
    'action' => ['site/login'],
    'method' => 'post',
    'id' => 'login',
    'enableAjaxValidation' => true,
]); ?>

<?= $form->field($model, 'username')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'rememberMe')->checkbox() ?>
<?= Html::submitButton() ?>
<?php ActiveForm::end() ?>



