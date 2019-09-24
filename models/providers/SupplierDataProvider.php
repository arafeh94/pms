<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\Supplier;

class SupplierDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = Supplier::find()->innerJoinWith('company');
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'company.name', 'label' => 'Company'],
            ['attribute' => 'name'],
            ['attribute' => 'phone'],
            ['attribute' => 'email'],
        ];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['name' => 'supplier.name', 'phone', 'email', 'company.name'];
    }
}