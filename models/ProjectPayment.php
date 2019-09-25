<?php

namespace app\models;

use app\components\extensions\AppActiveRecord;
use app\components\Tools;
use Yii;

/**
 * This is the model class for table "project_payment".
 *
 * @property int $id
 * @property int $project_id
 * @property string $method
 * @property double $amount
 * @property string $date_payment
 * @property string $crv_ref
 * @property double $inv_value
 * @property string $inv_ref
 * @property string $inv_date
 * @property double $due_amount
 * @property string $due_date
 * @property string $meta
 * @property int $is_deleted
 *
 * @property Project $project
 */
class ProjectPayment extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_payment';
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $sequence = ProjectPayment::find()->project($this->project->id)->count() + 1;
            $sequence = sprintf("%02d", $sequence);
            $this->inv_ref = 'ISD' . '-' . date('y') . '-' . $this->project->id . '-' . $sequence;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'is_deleted'], 'integer'],
            [['amount', 'inv_value', 'due_amount'], 'number'],
            [['date_payment', 'inv_date', 'due_date'], 'safe'],
            [['meta'], 'string'],
            [['method', 'crv_ref', 'inv_ref'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['project_id',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project'),
            'method' => Yii::t('app', 'Payment Method'),
            'amount' => Yii::t('app', 'Amount'),
            'date_payment' => Yii::t('app', 'Date Payment'),
            'crv_ref' => Yii::t('app', 'CRV Ref'),
            'inv_value' => Yii::t('app', 'INV Value'),
            'inv_ref' => Yii::t('app', 'INV Ref'),
            'inv_date' => Yii::t('app', 'INV Date'),
            'due_amount' => Yii::t('app', 'Due Amount'),
            'due_date' => Yii::t('app', 'Due Date'),
            'meta' => Yii::t('app', 'Meta'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return ProjectPaymentQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ProjectPaymentQuery(get_called_class());
    }
}
