<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentPlanRow]].
 *
 * @see StudentPlanRow
 */
class StudentPlanRowQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return StudentPlanRow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentPlanRow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
