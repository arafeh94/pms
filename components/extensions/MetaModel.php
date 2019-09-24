<?php /** @noinspection PhpUndefinedMethodInspection */

namespace app\components\extensions;

use yii\db\ActiveRecord;


/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/20/2019
 * Time: 11:15 AM
 */
class MetaModel
{
    public static function support($model)
    {
        return $model instanceof ActiveRecord && $model->hasAttribute('meta');
    }

    private static function checkSupport($model)
    {
        if (!self::support($model)) {
            throw new \Exception("provided active record don't support meta, please add meta column for it to work properly");
        }
    }

    /**
     * @param $model ActiveRecord
     * @param $key string
     * @param $value mixed
     * @throws \Exception
     */
    public static function set($model, $key, $value)
    {
        self::checkSupport($model);

        $meta = $model->meta ? json_decode($model->meta) : [];
        if ($meta && !is_array($meta)) {
            $meta = [$meta];
        }
        $meta[$key] = $value;
        $model->meta = json_encode($meta);
    }

    /**
     * @param $model ActiveRecord
     * @param $key string
     * @param $value mixed
     * @return bool
     * @throws \Exception
     */
    public static function save($model, $key, $value)
    {
        self::set($model, $key, $value);
        return $model->save();
    }

    public static function get($model, $key, $def = false, $assoc = true)
    {
        self::checkSupport($model);
        $json = json_decode($model->meta, $assoc);
        return isset($json[$key]) ? $json[$key] : $def;
    }

}