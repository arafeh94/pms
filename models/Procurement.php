<?php

namespace app\models;

use app\components\extensions\AppActiveRecord;
use Yii;

/**
 * This is the model class for table "procurement".
 *
 * @property int $id
 * @property int $project_id
 * @property int $supplier_id
 * @property int $brand_id
 * @property double $value
 * @property string $currency
 * @property string $se
 * @property double $se_fctr
 * @property string $se_status
 * @property double $se_cost
 * @property string $terms
 * @property string $po_ref
 * @property string $po_date
 * @property string $inv_ref
 * @property string $pr
 * @property string $type
 * @property int $is_deleted
 *
 * @property Brand $brand
 * @property Project $project
 * @property Supplier $supplier
 * @property ProcurementPayment[] $procurementPayments
 */
class Procurement extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'procurement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'supplier_id', 'brand_id', 'is_deleted'], 'integer'],
            [['value', 'se_fctr', 'se_cost'], 'number'],
            [['po_date'], 'safe'],
            [['currency', 'se', 'se_status', 'terms', 'po_ref', 'inv_ref', 'pr', 'type'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
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
            'supplier_id' => Yii::t('app', 'Supplier'),
            'brand_id' => Yii::t('app', 'Brand'),
            'value' => Yii::t('app', 'Value'),
            'currency' => Yii::t('app', 'Currency'),
            'se' => Yii::t('app', 'SE'),
            'se_fctr' => Yii::t('app', 'SE Factor'),
            'se_status' => Yii::t('app', 'SE Status'),
            'se_cost' => Yii::t('app', 'SE Cost'),
            'terms' => Yii::t('app', 'Terms'),
            'po_ref' => Yii::t('app', 'PO Ref'),
            'po_date' => Yii::t('app', 'PO Date'),
            'inv_ref' => Yii::t('app', 'INV Ref'),
            'pr' => Yii::t('app', 'PR'),
            'type' => Yii::t('app', 'Type'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
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
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcurementPayments()
    {
        return $this->hasMany(ProcurementPayment::className(), ['procurement_id' => 'id']);
    }

    /**
     * @return ProcurementQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ProcurementQuery(get_called_class());
    }
}
