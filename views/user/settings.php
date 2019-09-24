<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/24/2018
 * Time: 12:02 AM
 */

use app\components\extensions\MetaModel;
use kartik\widgets\ActiveForm;


/** @var $user \app\models\User */
$dbConf = MetaModel::get($user, 'dropbox', ['clientId' => '', 'clientSecret' => '', 'accessToken' => '',]);
?>

<div class="login-container card" style="width: 90%">
    <h2>Hello <?= $user->name ?></h2>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($user, 'password')->passwordInput()->label('Change Password') ?>
    <?= \yii\bootstrap\Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>

<?php if (\app\models\User::get()->type == 1): ?>
    <div class="login-container card" style="width: 90%">
        <h3>Updates</h3>
        <h4>May take time if there are major changes.</h4>
        <div style="text-align: center">
            <input type="submit" value="Update Application" class="btn btn-info" style="width: 100%"
                   onclick="location.href='update-application'">
        </div>
    </div>
<?php endif; ?>

<div class="login-container card" style="width: 90%">
    <h2>Dropbox Configuration</h2>

    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => ['user/dropbox']]) ?>
    <?php $dropbox = new \yii\base\DynamicModel(['clientId', 'clientSecret', 'accessToken']) ?>
    <?php $dropbox->addRule(['clientId', 'clientSecret', 'accessToken'], 'required') ?>
    <?= $form->field($dropbox, 'clientId')->textInput(['name' => 'dropbox[clientId]', 'value' => $dbConf['clientId']])->label('Client Id') ?>
    <?= $form->field($dropbox, 'clientSecret')->textInput(['name' => 'dropbox[clientSecret]', 'value' => $dbConf['clientSecret']])->label('Client Secret') ?>
    <?= $form->field($dropbox, 'accessToken')->textInput(['name' => 'dropbox[accessToken]', 'value' => $dbConf['accessToken']])->label('Access Token') ?>
    <?= \yii\bootstrap\Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
