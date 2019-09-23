<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\InvoiceItem;

class InvoiceItemDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = InvoiceItem::find()->innerJoinWith('project');
    }

    /**
     * @return array
     */
    function columns()
    {
        return ['project.po_number', 'code', 'orc_ref', 'quantity', 'price_ttl'];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.po_number', 'code', 'orc_ref', 'quantity', 'price_ttl'];
    }
}