<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\models\Procurement;
use yii\bootstrap\Html;
use yii\helpers\Url;

class ProcurementDataProvider extends AppDataProvider
{
    public $expandable = true;

    /**
     * @return void
     */
    function query()
    {
        $this->query = Procurement::find()
            ->innerJoinWith('brand')
            ->innerJoinWith('project')
            ->innerJoinWith('supplier');
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'project.name', 'label' => 'Project'],
            ['attribute' => 'supplier.name', 'label' => 'Supplier'],
            ['attribute' => 'brand.name', 'label' => 'Brand'],
            ['attribute' => 'type'],
            ['attribute' => 'pr'],
            ['attribute' => 'po_ref'],
            ['attribute' => 'se'],
            ['attribute' => 'se_status'],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['template'] = '{payments} ' . $actions['template'];
        $actions['buttons'] = array_merge($actions['buttons'], [
            'payments' => function ($key, $model, $index) {
                $url = Url::to([\Yii::$app->controller->id . '/payments', 'id' => $model->id]);
                return Html::tag('span', '', [
                    'class' => "glyphicon glyphicon-euro pointer",
                    'onclick' => "modalController.show('" . $url . "')",
                ]);
            }
        ]);
        return $actions;
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.name', 'supplier.name', 'brand.name', 'value', 'currency', 'type', 'terms', 'se_fctr', 'se_cost', 'pr', 'po_ref', 'po_date', 'se', 'se_status', 'inv_ref',];
    }
}