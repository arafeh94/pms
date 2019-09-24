<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use app\models\Attachment;
use kartik\grid\GridView;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\Model;
use yii\base\Widget;
use yii\behaviors\TimestampBehavior;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\widgets\ListView;

class FileUploadBehavior extends Behavior
{
    private $lock = 0;

    public function init()
    {
        parent::init();
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'upload',
            ActiveRecord::EVENT_AFTER_UPDATE => 'upload',
        ];
    }

    public function upload()
    {
        if ($this->lock != 0) return;
        $this->lock += 1;
        $form = new UploadForm();
        $form->file = UploadedFile::getInstance($form, 'file');
        if ($form->file) {
            $path = $form->upload();
            \Yii::$app->fs->folder($this->owner->tableName() . '/' . $this->owner->id . '/');
            $res = \Yii::$app->fs->upload($path)->path_lower;
            $attachment = new Attachment();
            $attachment->path = $res;
            $attachment->save();
            $this->owner->attachment_id = $attachment->id;
            $this->owner->save();
            $form->delete();
        }
    }


}