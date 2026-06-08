<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Faktur Penjualan PPn (Rincian & Detail)</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th>Faktur #</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Asuransi</th>
                <th>Amount</th>
                <th>Parts (Rp)</th>
                <th>Jasa (Rp)</th>
                <th>DPP Parts</th>
                <th>DPP Jasa</th>
                <th>Total DPP</th>
                <th>Ppn</th>
                <th>Pph</th>
                <th>Total</th>
                <th>WO #</th>
                <th>SPK Customer #</th>
                <th>Customer WO #</th>
                <th>Faktur Pajak #</th>
                <th>FP DPP</th>
                <th>FP PPn</th>
                <th>Bupot #</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->invoice_number), array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($header->created_datetime))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->subTotalAfterTax))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->productPriceAfterTax))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->servicePriceAfterTax))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->product_price))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->service_price))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->subTotal))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->ppn_total))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->pph_total))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_work_order_number')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer_document_order_number')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'transaction_tax_number')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->grand_total_coretax))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->tax_amount_coretax))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($header, 'coretax_receipt_number')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <!--    <tfoot>
            <tr id="header1">
                <td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: right; font-weight: bold"> <?php /*echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotal($saleInvoiceSummary->dataProvider))); ?></td>
                <td style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalPayment($saleInvoiceSummary->dataProvider))); ?></td>
                <td style="text-align: right; font-weight: bold"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportTotalRemaining($saleInvoiceSummary->dataProvider)));*/ ?></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>-->
    </table>
</div>