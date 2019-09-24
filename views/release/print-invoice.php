<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 3:47 PM
 */

/* @var $this \yii\web\View */
/* @var $invoices \app\models\Invoice[] */
/* @var $project \app\models\Project */
/* @var $recovery int */
/* @var $inv_ref string */

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    body {
        padding: 24px;
    }

    div .summary {
        display: none;
    }

    .header table td {
        padding: 4px;
        color: rgb(126, 136, 107);

    }

    .introduction {
        padding-bottom: 16px;
        color: rgb(220, 220, 220);
    }

    .format1 {
        color: gray;
        font-size: 9pt;
    }

    .header {
        background-color: rgb(224, 228, 219);
    }

    .ft td {
        font-size: 20px;
    }

    .grid-view th {
        white-space: nowrap;
    }

    .kv-page-summary td {
        font-weight: bold;
    }

    @media print {
        .table td {
            background-color: #eef5f6 !important;
        }

        .table th {
            background-color: #fff !important;
        }

        .kv-page-summary td {
            font-weight: bold;
        }

    }


</style>


<div class="introduction">
    <div class="header" style="padding: 8px;margin-bottom: 8px;">
        <div style="position:absolute;width: 100%;right: 30px;text-align: right">
            <?= \yii\bootstrap\Html::img('@web/images/logo.png', ['style' => 'width:260px']) ?>
            <table style="position:inherit;right: 0px;">
                <tr>
                    <td>ID_PROJECT <?= $project->id ?></td>
                </tr>
                <tr>
                    <td>
                        <div style="max-width: 250px;font-size: 12pt">
                            <?= $project->terms ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-bottom: 48px;" class="ft">
            <h1 style="color: rgb(130,130,130)">Invoice</h1>
            <div>
                <table>
                    <tr>
                        <td width="200px">Invoice Reference</td>
                        <td><?= $inv_ref ?></td>
                    </tr>
                    <tr>
                        <td>Company</td>
                        <td><?= $project->company->name ?></td>
                    </tr>
                    <tr>
                        <td>PO Reference</td>
                        <td><?= $project->po_number ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $invoices]),
        'columns' => [['attribute' => 'code', 'pageSummary' => 'Net Value'], 'description', 'brand.name',
            ['attribute' => 'quantity', 'pageSummary' => function ($v) use ($recovery) {
                return $recovery == 100 ? '' : 'Payment: ' . $recovery . '%';
            }],
            ['attribute' => 'price_ttl', 'pageSummary' => function ($v) use ($recovery) {
                return ($v * $recovery / 100) . 'QAR';
            }]],
        'showPageSummary' => true,
    ]) ?>

    <div style="margin-top: 8px">
        <div class="format1">
            Account Name: Darwish Technology<br>
            Bank Name: Commercial Bank Of Qatar- CBQ<br>
            Bank Address: Box 3232 Doha- Qatar<br>
            Swift Code: CBQAQAQA<br>
            Account Number: 4580-584240/001<br>
            IBAN: QA02CBQA000000004580584240001<br>
            Currency: QAR- Qatari Riyals<br>
        </div>
        <h5 style="margin: 8px;color: black">Sincerely,</h5>
        <table>
            <tr>
                <td style="width: 10%">_______________________</td>
                <td style="width: 10%">_______________________</td>
                <td style="width: 10%">_______________________</td>
            </tr>
            <tr>
                <td>Confirmed By</td>
                <td>Verified By</td>
                <td>Approved By</td>
            </tr>
        </table>

        <center>
            <div class="format1" style="width 100%;margin: 16px">
                For further inquiries please do not hesitate to contact us on our direct line: +974 44257828 or you can
                send<br>
                FAX at +974 44314700 or send mail to PED.Admin@Darwishholding.com<br>
                Thank you for your business!<br>
            </div>
        </center>
    </div>
</div>


<script>
    window.addEventListener('load', function () {
        window.print();
    });
</script>