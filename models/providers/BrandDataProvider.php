<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\Brand;

class BrandDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = Brand::find();
    }

    /**
     * @return array
     */
    function columns()
    {
        return ['name'];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['name'];
    }
}