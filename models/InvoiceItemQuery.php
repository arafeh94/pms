<?php

namespace app\models;

use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Invoice]].
 *
 * @see Invoice
 */
class InvoiceItemQuery extends AppModelQuery
{
    /**
     * @inheritdoc
     * @return InvoiceItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InvoiceItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function project($id)
    {
        return $this->andWhere(['project_id' => $id]);
    }

}
