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

class DropboxDownloadButton extends ActionColumn
{

    public $template = '{download}';

    public $header = 'Download';

    public function init()
    {
        parent::init();
    }

    protected function initDefaultButtons()
    {
        $this->buttons = [
            'download' => function ($key, $model, $index) {
                $url = Url::to(["site/dropbox", 'path' => $model->path]);
                return Html::a('<span class="glyphicon glyphicon-download pointer"></span>', $url, ['data-pjax' => 0, 'target' => '_blank']);
            }
        ];
    }
}