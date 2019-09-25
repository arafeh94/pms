<?php

namespace app\models;

use app\components\extensions\AppActiveRecord;
use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property string $path
 *
 * @property Project[] $projects
 * @property int $is_deleted [int(11)]
 * @property string $owner [varchar(255)]
 * @property int $owner_id [int(11)]
 */
class Attachment extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'owner'], 'string', 'max' => 255],
            [['is_deleted', 'owner_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Path'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['attachment_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AttachmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttachmentQuery(get_called_class());
    }
}
