<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    private $uploaded;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true,],
        ];
    }

    public function upload()
    {
        $path = '../uploads/' . $this->file->baseName . '.' . $this->file->extension;
        $path = \Yii::getAlias($path);
        $path = strtolower($path);
        $result = $this->file->saveAs($path, true);
        if ($result) {
            $this->uploaded = $path;
            return $path;
        } else {
            return false;
        }
    }

    public function delete()
    {
        unlink(\Yii::getAlias($this->uploaded));
    }
}