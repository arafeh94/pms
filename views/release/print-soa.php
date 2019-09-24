<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 3:47 PM
 */

/* @var $this \yii\web\View */
/* @var $project \app\models\Project */
/* @var $payments  \app\models\ProjectPayment[] */
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    body {
        margin: 16px;
    }

    div .summary {
        display: none;
    }

    .format1 {
        color: darkslategray;
        font-size: 10pt;
    }

    table th {
        color: darkslategray;
        font-weight: bold;
    }

    .table td {
        background-color: #eef5f6 !important;
    }

    .table tr:nth-child(even) td {
        background-color: #fff !important;
    }

    .table th {
        background-color: #fff !important;
    }

    .grid-view th {
        white-space: nowrap;
    }

    @media print {
        table th {
            color: darkslategray;
            font-weight: bold;
        }

        .table td {
            background-color: #eef5f6 !important;
        }

        .table tr:nth-child(even) td {
            background-color: #fff !important;
        }

        .table th {
            background-color: #fff !important;
        }
    }

    .bottom {
        position: absolute;
        bottom: auto;
        margin-bottom: 16px;
        width: 98%
    }
</style>

<div>
    <div>
        <?= \yii\helpers\Html::img('@web/images/logo.png') ?>
    </div>
    <div style="width: 100%;margin-top: 16px">
        <span style="width: 100%;text-align: right;position: absolute;right: 24px;font-size: 18px;align-content: center;line-height: 10px;">
                <?= \app\components\Tools::currentDate() ?>
        </span>
        <h2>Statement Of Account</h2>
        <div style="margin: 18px 72px">
            <h4>Darwish Technology</h4>
            <h6><i>Branch of Modern Home - Member of Darwish Holding</i></h6>
            <div>
                Salwa Road<br>
                Qatar, Doha/+974/615
            </div>
        </div>
    </div>
    <div>
        <table style="width: 70%;margin: 16px 48px">
            <tr>
                <th colspan="2">For Customer</th>
                <th colspan="2">For Project</th>
            </tr>
            <tr>
                <th width="200px">Customer Name</th>
                <td width="200px"><?= $project->customer->name ?></td>
                <th width="200px">Project Name</th>
                <td width="200px"><?= $project->name . '-' . $project->po_number ?></td>
            </tr>
            <tr>
                <th>Customer Address</th>
                <td><?= $project->customer->address ?></td>
                <th>ProjectID</th>
                <td><?= $project->id ?></td>
            </tr>
            <tr>
                <th>City, State, Zip</th>
                <td><?= $project->customer->city . ',' . $project->customer->state . ',' . $project->customer->zip ?></td>
                <th>Employee Name</th>
                <td><?= $project->employee->name ?></td>
            </tr>
            <tr>
                <th>Business Phone</th>
                <td><?= $project->customer->phone ?></td>
                <th>Order Value</th>
                <td><?= $project->order_value ?></td>
            </tr>
            <tr>
                <th>Country/Region</th>
                <td><?= $project->customer->address ?></td>
                <th>Warranty</th>
                <td><?= $project->notes ?></td>
            </tr>
        </table>
    </div>
    <div style="margin: 48px 24px">
        <div>
            <?= \kartik\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => [$project]]),
                'columns' => ['po_number', 'terms', ['attribute' => 'date_end', 'format' => 'date'], 'order_value',],
            ]); ?>
        </div>
        <div>
            <?= \kartik\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $payments]),
                'columns' => [
                    ['attribute' => 'inv_value'],
                    ['attribute' => 'inv_ref'],
                    ['attribute' => 'inv_date'],
                    ['attribute' => 'due_amount', 'pageSummary' => function ($v) {
                        return $v . 'QAR';
                    }],
                    ['attribute' => 'date_payment', 'format' => 'date'],
                    ['attribute' => 'amount', 'pageSummary' => function ($v) {
                        return $v . ' QAR';
                    }]
                    , 'method', 'crv_ref'
                ],
                'showPageSummary' => true,
            ]); ?>
        </div>
    </div>
    <div>
        <h6 style="margin: 48px;color: gray;font-weight: bold">Sincerely,</h6>
        <div class="format1">
            For further inquiries please do not hesitate to contact us on our direct line: +974 44257828 or you can send<br>
            FAX at +974 44314700 or<br>
            send mail to PED.Admin@Darwishholding.com<br>
        </div>
        <div style="font-weight: bold;margin-left: 24px" class="format1">
            Thank you for your business!
        </div>

        <div style="text-align: center" class="format1 bottom">
            OP-FM-DT-048 / Rev 1 / 16th of OCT 2018<br>
            Salwa Road P.O. Box 615-Doha - Qatar<br>
            T: +974 44257777 |F: +974-44314700<br>
            www.darwishholding.com<br>
        </div>
        <div style="text-align: right" class="bottom">
            <?= \yii\bootstrap\Html::img('@web/images/logo2.png', ['style' => 'width:240px']) ?>
        </div>
    </div>
</div>


<script>
    window.addEventListener('load', function () {
        window.print();
    });
</script>