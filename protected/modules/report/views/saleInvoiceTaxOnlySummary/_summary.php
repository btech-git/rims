<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 8% }
    .width1-2 { width: 8% }
    .width1-3 { width: 8% }
    .width1-4 { width: 8% }
    .width1-5 { width: 8% }
    .width1-6 { width: 9% }
    .width1-7 { width: 8% }
    .width1-8 { width: 8% }
    .width1-9 { width: 8% }
    .width1-10 { width: 5% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
    .width2-5 { width: 15% }
'); ?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Faktur Penjualan PPn</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th class="width1-1">Faktur #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-2">Customer</th>
                <th class="width1-3">Amount</th>
                <th class="width1-4">Parts (Rp)</th>
                <th class="width1-5">Jasa (Rp)</th>
                <th class="width1-6">DPP Parts</th>
                <th class="width1-7">DPP Jasa</th>
                <th class="width1-8">Total DPP</th>
                <th class="width1-9">Ppn</th>
                <th class="width1-10">Pph</th>
                <th class="width1-11">Total</th>
                <th class="width1-12">SPK #</th>
                <th class="width1-13">Faktur Pajak #</th>
                <th class="width1-14">FP Amount</th>
                <th class="width1-15">Bupot #</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($header->created_datetime))); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer.name')); ?>
                    </td>
                    <td class="width1-3" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->subTotalAfterTax))); ?>
                    </td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->productPriceAfterTax))); ?>
                    </td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->servicePriceAfterTax))); ?>
                    </td>
                    <td class="width1-6" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->product_price))); ?>
                    </td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->service_price))); ?>
                    </td>
                    <td class="width1-8" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->subTotal))); ?>
                    </td>
                    <td class="width1-9" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->ppn_total))); ?>
                    </td>
                    <td class="width1-10" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->pph_total))); ?>
                    </td>
                    <td class="width1-11" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?>
                    </td>
                    <td class="width1-12" style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')); ?>
                    </td>
                    <td class="width1-13" style="text-align: right"></td>
                    <td class="width1-14" style="text-align: right"></td>
                    <td class="width1-15" style="text-align: right"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <!--    <tfoot>
            <tr id="header1">
                <td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
                <td class="width1-8" style="text-align: right; font-weight: bold"> <?php /*echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($saleInvoiceSummary->dataProvider))); ?></td>
                <td class="width1-9" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($saleInvoiceSummary->dataProvider))); ?></td>
                <td class="width1-10" style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($saleInvoiceSummary->dataProvider)));*/ ?></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>-->
    </table>
</div>