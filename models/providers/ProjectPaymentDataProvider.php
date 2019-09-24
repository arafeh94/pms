<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\ProjectPayment;

class ProjectPaymentDataProvider extends AppDataProvider
{
    public $expandable = true;

    /**
     * @return void
     */
    function query()
    {
        $this->query = ProjectPayment::find()
            ->innerJoinWith('project')
            ->innerJoinWith('project.customer')
            ->innerJoinWith('project.category');
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'project.name'],
            ['attribute' => 'project.customer.name', 'label' => 'Customer'],
            ['attribute' => 'project.category.name', 'label' => 'Category'],
            ['attribute' => 'amount'],
            ['attribute' => 'date_payment', 'as' => 'date'],
            ['attribute' => 'method'],
            ['attribute' => 'crv_ref'],
            ['attribute' => 'due_date', 'as' => 'date'],
        ];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.name', 'project.customer.name', 'project.category.name', 'amount', 'date_payment', 'method', 'crv_ref', 'due_date', 'inv_ref', 'inv_value', 'inv_date', 'due_amount',];
    }
}