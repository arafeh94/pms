<?php

namespace app\controllers;


use app\components\Cached;
use app\components\extensions\Search;
use app\components\Tools;
use app\models\InvoiceItem;
use app\models\Project;
use app\models\ProjectPayment;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ReleaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionInvoice()
    {
        $invoices = [];
        $project = false;
        $model = new Search(['project_id', 'recovery']);
        $model->addRule(['project_id'], 'required');
        $model->addRule(['recovery'], 'number');
        $inv_ref = "Select Project First";

        $loaded = $model->load(Yii::$app->request->get()) && $model->validate();

        if ($loaded) {
            $invoices = InvoiceItem::find()->project($model->toArray()['project_id'])->all();
            $project = Project::find()->with('company')->with('customer')->with('employee')->id($model->toArray()['project_id'])->one();
        }

        if ($project) {
            $lastPayment = ProjectPayment::find()->project($project->id)->orderBy(['id' => SORT_DESC])->limit(1)->one();
            $inv_ref = $lastPayment ? $lastPayment->inv_ref : $inv_ref;
        }

        Cached::put('print-invoice-recovery', $model->toArray()['recovery']);
        Cached::put('print-invoice-data', $invoices);
        Cached::put('print-invoice-ref', $inv_ref);
        Cached::put('print-project', $project);

        return $this->render('invoice', ['model' => $model, 'invoices' => $invoices, 'project' => $project, 'inv_ref' => $inv_ref]);
    }


    public function actionPrintInvoice()
    {
        $recovery = Cached::get('print-invoice-recovery', 0);
        $invoices = Cached::get('print-invoice-data', []);
        $project = Cached::get('print-project', null);
        $inv_ref = Cached::get('print-invoice-ref', null);
        if ($project == null) {
            throw new BadRequestHttpException('Project is missing, you have to select a project first');
        } else {
            return $this->renderPartial('print-invoice', ['invoices' => $invoices, 'project' => $project, 'recovery' => $recovery, 'inv_ref' => $inv_ref]);
        }
    }


    public function actionAcceptance()
    {
        $project = false;
        $model = new Search(['project_id']);
        $model->addRule(['project_id'], 'required');
        $loaded = $model->load(Yii::$app->request->get()) && $model->validate();

        if ($loaded) {
            $project = Project::find()->with('company')->with('customer')->with('employee')->id($model->toArray()['project_id'])->one();
        }

        Cached::put('print-project', $project);

        return $this->render('acceptance', ['model' => $model, 'project' => $project]);
    }


    public function actionPrintAcceptance()
    {
        $project = Cached::get('print-project', null);

        return $this->renderPartial('print-acceptance', ['project' => $project]);
    }

    public function actionSoa()
    {
        $payments = [];
        $project = false;
        $model = new Search(['project_id']);
        $model->addRule(['project_id'], 'required');
        $loaded = $model->load(Yii::$app->request->get()) && $model->validate();

        if ($loaded) {
            $payments = ProjectPayment::find()->project($model->toArray()['project_id'])->all();
            $project = Project::find()->with('company')->with('customer')->with('employee')->id($model->toArray()['project_id'])->one();
        }

        Cached::put('print-payments-data', $payments);
        Cached::put('print-project', $project);

        return $this->render('soa', ['model' => $model, 'payments' => $payments, 'project' => $project]);
    }

    public function actionPrintSoa()
    {
        $payments = Cached::get('print-payments-data', []);
        $project = Cached::get('print-project', null);

        return $this->renderPartial('print-soa', ['project' => $project, 'payments' => $payments]);
    }


}
