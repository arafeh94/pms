<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\db\Connection;
use yii\helpers\Json;

class Tools extends Component
{
    static function forcePrint($message)
    {
        $message = Json::encode($message);
        throw new \RuntimeException($message);
    }

    static function var_dump($message)
    {
        die(var_dump($message));
    }

    static function prettyPrint($message)
    {
        $message = Json::encode($message);
        echo "<pre><code>$message</code></pre>";
    }

    static function console($msg)
    {
        $msg = json_encode($msg);
        \Yii::$app->view->registerJs("console.log({$msg})");
    }

    public static function currentDate()
    {
        $time = new \DateTime('now', new \DateTimeZone(\Yii::$app->params['timezone']));
        return $time->format(\Yii::$app->params['dateTimeFormat']);
    }

    public static function actionExists($controller, $action)
    {
        return Yii::$app->createController($controller . $action) != false;
    }

    /**
     * @param $value
     * @return bool|\DateTime
     */
    static function date($value)
    {
        if (!$value) {
            return false;
        }

        try {
            return new \DateTime($value);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function random($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getLetterUntilNumberFound($str)
    {
        $matches = [];
        if (preg_match('/^([A-Z]+)([0-9]+)$/i', $str, $matches)) {
            return $matches ? $matches[1] : false;
        }
        return false;
    }


    static function array_keys($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[] = is_numeric($key) ? $value : $key;
        }
        return $result;
    }

    static function array_key_val($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $k = is_numeric($key) ? $value : $key;
            $result[$k] = $value;
        }
        return $result;
    }

    static function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    /**
     * @param string $haystack The string to search in
     * @param mixed $needle
     * @return boolean
     */
    static function str_starts_with($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param string $haystack The string to search in
     * @param mixed $needle
     * @return boolean
     */
    static function str_ends_with($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

}