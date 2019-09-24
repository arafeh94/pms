<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use kartik\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

class DropboxButton extends ActionColumn
{

    public $template = '{attachment}';

    public $header = '<span class="glyphicon glyphicon-link pointer"></span>';

    public function init()
    {
        parent::init();
    }

    protected function initDefaultButtons()
    {
        $this->buttons = [
            'attachment' => function ($key, $model, $index) {
                if ($model->attachment) {
                    $url = Url::to(["site/dropbox", 'path' => $model->attachment->path]);
                    return Html::a('<span class="glyphicon glyphicon-link pointer"></span>', $url, ['data-pjax' => 0, 'target' => '_blank']);
                } else {
                    return "";
                }
            }
        ];
    }
}