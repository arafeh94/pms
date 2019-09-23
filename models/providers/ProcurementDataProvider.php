<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\components\GridConfig;
use app\components\Tools;
use app\models\Course;
use app\models\Customer;
use app\models\Department;
use app\models\Major;
use app\models\Procurement;
use app\models\Project;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Boolean;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ProcurementDataProvider extends AppDataProvider
{

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
            ['attribute' => 'project.po_number'],
            ['attribute' => 'supplier.name', 'label' => 'Supplier'],
            ['attribute' => 'brand.name', 'label' => 'Brand'],
            ['attribute' => 'value'],
            ['attribute' => 'pr'],
            ['attribute' => 'po_ref'],
            ['attribute' => 'po_date', 'include' => 'date'],

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
        return ['project.po_number', 'supplier.name', 'brand.name', 'value', 'pr', 'po_ref', 'po_date'];
    }
}