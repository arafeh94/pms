<?php

namespace app\controllers;

use app\components\Cached;
use app\components\Tools;
use app\components\UploadForm;
use app\models\Attachment;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

class AttachmentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex($owner, $owner_id)
    {
        $attachments = Attachment::find()->of($owner, $owner_id)->all();
        return $this->render('index', ['attachments' => $attachments]);
    }

    public function actionUpload()
    {
        $uploaded = false;
        $attachment = new Attachment();
        $loaded = $attachment->load(\Yii::$app->request->post()) && $attachment->validate();
        if ($loaded) {
            $form = new UploadForm();
            $form->file = UploadedFile::getInstance($form, 'file');
            if ($form->file) {
                $path = $form->upload();
                \Yii::$app->fs->folder($attachment->owner . '/' . $attachment->owner_id . '/');
                $res = \Yii::$app->fs->upload($path)->path_lower;
                $attachment->path = $res;
                $attachment->save();
                $form->delete();
                $uploaded = true;
            }
        }
        Cached::put('file-uploaded', $uploaded);
        $this->redirect(['attachment/index', 'owner_id' => $attachment->owner_id, 'owner' => $attachment->owner]);
    }
}
