<?php

namespace app\models;

use app\components\GridConfig;
use phpDocumentor\Reflection\Types\Object_;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 *
 * @property int $id [int(11)]
 * @property string $username [varchar(255)]
 * @property string $password [varchar(255)]
 * @property string $email [varchar(255)]
 * @property string $first_name [varchar(255)]
 * @property string $last_name [varchar(255)]
 * @property int $type [int(11)]
 * @property string $is_deleted [bit(1)]
 * @property int $DateAdded [timestamp]
 * @property string $meta
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static $ADMIN = 1;
    public static $USER = 2;

    /**
     * @return IdentityInterface|User
     */
    public static function get()
    {
        return Yii::$app->user->identity;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * todo add minimum
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name', 'type', 'email'], 'required'],
            [['type'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['username', 'password', 'name'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetAttribute' => ['username'], 'filter' => ['is_deleted' => 0]],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'is_deleted' => 0]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username, 'is_deleted' => 0]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


}
