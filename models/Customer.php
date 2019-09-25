<?php

namespace app\models;

use app\components\extensions\AppActiveRecord;
use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $email
 * @property string $meta
 * @property int $attachment_id
 * @property int $is_deleted
 * @property string $phone
 * @property string $country
 * @property string $zip
 * @property string $state
 * @property string $city
 * @property string $address [varchar(255)]
 *
 * @property Company $company
 * @property Project[] $projects
 */
class Customer extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'attachment_id', 'is_deleted'], 'integer'],
            [['meta'], 'string'],
            [['name', 'email', 'phone', 'country', 'zip', 'state', 'city', 'address'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['company_id',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'meta' => Yii::t('app', 'Meta'),
            'attachment_id' => Yii::t('app', 'Attachment'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'phone' => Yii::t('app', 'Phone'),
            'country' => Yii::t('app', 'Country'),
            'zip' => Yii::t('app', 'Zip'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['customer_id' => 'id']);
    }

    /**
     * @return CustomerQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
