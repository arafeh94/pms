<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\DropboxButton;
use app\components\extensions\AppDataProvider;
use app\models\Project;

class ProjectDataProvider extends AppDataProvider
{
    public $expandable = true;

    public function query()
    {
        $this->query = Project::find()
            ->innerJoinWith('customer')
            ->innerJoinWith('company')
            ->innerJoinWith('category')
            ->innerJoinWith('employee');
    }

    public function columns()
    {
        return [
            ['attribute' => 'id'],
            ['attribute' => 'name'],
            ['attribute' => 'customer.name', 'label' => 'Customer',],
            ['attribute' => 'category.name', 'label' => 'Category'],
            ['attribute' => 'status',],
            ['attribute' => 'employee.name', 'label' => 'Employee'],
            ['attribute' => 'date_begin', 'as' => ['date']],
            ['attribute' => 'date_end', 'as' => ['date']],
            ['attribute' => 'po_number',],
            ['class' => DropboxButton::className(),],
        ];
    }


    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['id' => 'project.id', 'po_number', 'name' => 'project.name', 'order_value', 'customer.name', 'category.name', 'date_begin', 'date_end', 'status', 'employee.name'];
    }


}