<?php

namespace app\controllers;

use app\components\extensions\AppController;
use app\models\Procurement;
use app\models\ProcurementPayment;
use app\models\providers\ProcurementPaymentDataProvider;

class ProcurementController extends AppController
{

    public $model = 'Procurement';

    public function actionPayments($id)
    {
        $dataProvider = new ProcurementPaymentDataProvider(['procurement_id' => $id]);
        return $this->renderPartial('payments', ['provider' => $dataProvider, 'procurement_id' => $id]);
    }

    public function actionAddPayment($id)
    {
        $dataProvider = new ProcurementPaymentDataProvider(['procurement_id' => $id]);
        $model = new ProcurementPayment();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $model = new ProcurementPayment();
        }

        $model->procurement_id = $id;
        return $this->render('add-payment', ['model' => $model, 'procurement_id' => $id, 'provider' => $dataProvider]);
    }
}
