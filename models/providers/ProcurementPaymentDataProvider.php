<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\ProcurementPayment;

class ProcurementPaymentDataProvider extends AppDataProvider
{

    public $procurement_id = null;

    /**
     * @return void
     */
    function query()
    {
        $this->query = ProcurementPayment::find()
            ->innerJoinWith('procurement');
        if ($this->procurement_id) {
            $this->query->andWhere(['procurement_id' => $this->procurement_id]);
        }
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'date', 'include' => 'date', 'pageSummary' => 'Total'],
            ['attribute' => 'amount', 'pageSummary' => true],
        ];
    }

    public function actions()
    {
        return [];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return [];
    }
}