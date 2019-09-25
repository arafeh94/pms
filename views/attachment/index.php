<?php

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/25/2019
 * Time: 5:57 PM
 */

use kartik\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $attachments \app\models\Attachment[]|array */
$attachment = new \app\models\Attachment();
?>

<div class="card" style="width: 325px;margin: auto auto 32px;">
    <?php $form = ActiveForm::begin([
        'id' => 'model-form',
        'action' => ['attachment/upload'],
        'options' => ['data-pjax' => '', 'enctype' => 'multipart/form-data'],
    ]) ?>

    <?= $form->field($attachment, 'owner')->hiddenInput(['value' => Yii::$app->request->get('owner')])->label(false) ?>
    <?= $form->field($attachment, 'owner_id')->hiddenInput(['value' => Yii::$app->request->get('owner_id')])->label(false) ?>
    <?= $form->field(new \app\components\UploadForm(), 'file')->label('Add Attachment')->fileInput(['class' => 'form-control']) ?>

    <div class="button-container">
        <?= \yii\helpers\Html::submitButton(\yii\helpers\Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' upload', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<h3>Attachments</h3>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $attachments]),
    'columns' => ['path', ['class' => \app\components\DropboxDownloadButton::className()]]
]) ?>


