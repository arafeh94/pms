<?php

namespace app\models;

use app\components\extensions\AppActiveRecord;
use Yii;

/**
 * This is the model class for table "project_expense".
 *
 * @property int $id
 * @property int $project_id
 * @property int $employee_id
 * @property string $date_expense
 * @property string $order_ref
 * @property double $order_amount
 * @property string $meta
 * @property string $remark
 * @property int $is_deleted
 *
 * @property Project $project
 * @property Employee $employee
 */
class ProjectExpense extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_expense';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'employee_id', 'is_deleted'], 'integer'],
            [['date_expense'], 'safe'],
            [['order_amount'], 'number'],
            [['meta', 'remark'], 'string'],
            [['order_ref',], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
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
            'employee_id' => Yii::t('app', 'Employee'),
            'date_expense' => Yii::t('app', 'Date Expense'),
            'order_ref' => Yii::t('app', 'Order Ref'),
            'order_amount' => Yii::t('app', 'Order Amount'),
            'meta' => Yii::t('app', 'Meta'),
            'remark' => Yii::t('app', 'Remark'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }


    /**
     * @inheritdoc
     * @return ProjectExpenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectExpenseQuery(get_called_class());
    }
}
