<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_item".
 *
 * @property int $id
 * @property int $project_id
 * @property int $brand_id
 * @property string $code
 * @property string $old_code
 * @property string $description
 * @property double $quantity
 * @property double $price
 * @property double $price_ttl
 * @property string $orc_ref
 * @property string $se_ref
 * @property string $order_status
 * @property double $fob_cost
 * @property double $fob_ttl
 * @property string $currency
 * @property double $orc_cost
 * @property double $orc_ttl
 * @property int $pft
 * @property int $is_deleted
 *
 * @property Brand $brand
 * @property Project $project
 */
class InvoiceItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'brand_id', 'is_deleted', 'pft'], 'integer'],
            [['quantity', 'price', 'price_ttl', 'fob_cost', 'fob_ttl', 'orc_cost', 'orc_ttl'], 'number'],
            [['code', 'old_code', 'description', 'orc_ref', 'se_ref', 'order_status', 'currency'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'brand_id' => Yii::t('app', 'Brand'),
            'code' => Yii::t('app', 'Code'),
            'old_code' => Yii::t('app', 'Old Code'),
            'description' => Yii::t('app', 'Description'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'price_ttl' => Yii::t('app', 'Total Price'),
            'se_ref' => Yii::t('app', 'SE Reference'),
            'order_status' => Yii::t('app', 'Order Status'),
            'fob_cost' => Yii::t('app', 'FOB Cost'),
            'fob_ttl' => Yii::t('app', 'FOB Total'),
            'currency' => Yii::t('app', 'Currency'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'orc_ref' => Yii::t('app', 'ORC Reference'),
            'orc_cost' => Yii::t('app', 'ORC Cost'),
            'orc_ttl' => Yii::t('app', 'ORC Total'),
            'pft' => Yii::t('app', 'PFT'),
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
     * @return InvoiceItemQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new InvoiceItemQuery(get_called_class());
    }
}
