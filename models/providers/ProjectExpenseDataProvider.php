<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\ProjectExpense;

class ProjectExpenseDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = ProjectExpense::find()
            ->innerJoinWith('employee')
            ->innerJoinWith('project');
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'project.name', 'label' => 'Project', ],
            ['attribute' => 'employee.name', 'label' => 'Employee'],
            ['attribute' => 'order_ref',],
            ['attribute' => 'order_amount'],
            ['attribute' => 'date_expense', 'as' => 'date'],
        ];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.po_number', 'project.name', 'employee.name', 'order_ref', 'order_amount', 'date_expense'];
    }
}