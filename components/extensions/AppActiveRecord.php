<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/24/2019
 * Time: 7:01 AM
 */

namespace app\components\extensions;


use app\components\Tools;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class AppActiveRecord extends ActiveRecord
{

    public function beforeValidate()
    {
        foreach ($this->toArray() as $key => $value) {
            if (strpos($key, 'date') !== false) {
                if ($date = Tools::date($value)) {
                    $this->setAttribute($key, $date->format('Y-m-d'));
                }
            }
        }
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        foreach ($this->toArray() as $key => $value) {
            if (strpos($key, 'date') !== -1) {
                if ($date = Tools::date($value)) {
                    $format = ArrayHelper::getValue(\Yii::$app->params, 'dateFormat', 'Y-m-d');
                    $this->setAttribute($key, $date->format($format));
                }
            }
        }
        parent::afterFind();
    }

}