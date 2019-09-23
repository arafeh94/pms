<?php

namespace app\models;

use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProjectPayment]].
 *
 * @see ProjectPayment
 */
class ProjectPaymentQuery extends AppModelQuery
{


    /**
     * @inheritdoc
     * @return ProjectPayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param $id
     * @return ActiveQuery
     */
    public function project($id)
    {
        return $this->andWhere(['project_id' => $id]);
    }

}
