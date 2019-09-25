<?php

namespace app\models;

use app\components\extensions\AppModelQuery;

/**
 * This is the ActiveQuery class for [[Attachment]].
 *
 * @see Attachment
 */
class AttachmentQuery extends AppModelQuery
{


    /**
     * @inheritdoc
     * @return Attachment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Attachment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $owner
     * @param $owner_id
     * @return AttachmentQuery
     */
    public function of($owner, $owner_id)
    {
        return $this->andWhere(['owner' => $owner, 'owner_id' => $owner_id]);
    }
}
