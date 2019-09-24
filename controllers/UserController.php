<?php

namespace app\controllers;

use app\components\ConsoleRunner;
use app\components\extensions\MetaModel;
use app\components\Shell;
use app\components\Tools;
use app\models\providers\UserDataProvider;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['settings', 'change-pass'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new UserDataProvider();
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(User::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('User')['UserId'];
            $model = $id === "" ? new User() : User::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->password = 'default';
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', ['model' => $model, 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $user = User::findOne($id);
            $user->is_deleted = 1;
            return $user->save();
        }
        return false;
    }

    public function actionSettings()
    {
        $post = \Yii::$app->request->post();
        /** @var User $model */
        $model = \Yii::$app->user->identity;
        if ($model->load($post) && $model->validate()) {
            $model->save();
            \Yii::$app->user->logout();
            $this->goHome();
            \Yii::$app->end();
        }
        return $this->render('settings', ['user' => $model]);
    }

    public function actionUpdateApplication()
    {
        set_time_limit(0);
        $git = exec('git pull');
        $composer = exec('php ../composer.phar install');
        $database = exec('php ../yii migrate');
        return $this->render('update', ['git' => $git, 'composer' => $composer, 'database' => $database]);
    }

    public function actionDropbox()
    {
        $dropbox = \Yii::$app->request->post('dropbox');
        $file = fopen('../config/dropbox.json', 'w');

        fclose($file);
        return $this->redirect(['user/settings']);
    }

}
