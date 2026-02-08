<div class="row">
    <p><h2>Payment In Retail</h2></p>
    <?php $this->renderPartial('_detailPaymentInRetail', array(
        'paymentTypes' => $paymentTypes,
        'transactionDate' => $transactionDate,
        'paymentInRetailResultSet' => $paymentInRetailResultSet,
        'paymentInRetailList' => $paymentInRetailList,
    )); ?>
</div>

<div class="row">
    <p><h2>Payment In Non Retail</h2></p>
    <?php $this->renderPartial('_detailPaymentInWholesale', array(
        'paymentInWholesale' => $paymentInWholesale,
        'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
        'transactionDate' => $transactionDate,
    )); ?>
</div>

<div class="row">
    <p><h2>Payment Out</h2></p>
    <?php $this->renderPartial('_detailPaymentOut', array(
        'paymentOut' => $paymentOut,
        'paymentOutDataProvider' => $paymentOutDataProvider,
        'transactionDate' => $transactionDate,
    )); ?>
</div>

<div class="row">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Jurnal Penyesuaian' => array(
                'content' => $this->renderPartial('_viewTransactionJournal', array(
                    'transactionJournal' => $transactionJournal,
                    'transactionJournalDataProvider' => $transactionJournalDataProvider,
                ), true),
            ),
            'Transaction In' => array(
                'content' => $this->renderPartial('_detailCashTransactionIn', array(
                    'cashTransaction' => $cashTransaction,
                    'cashTransactionInDataProvider' => $cashTransactionInDataProvider,
                    'transactionDate' => $transactionDate,
                ), true),
            ),
            'Transaction Out' => array(
                'content' => $this->renderPartial('_detailCashTransactionOut', array(
                    'cashTransaction' => $cashTransaction,
                    'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
                    'transactionDate' => $transactionDate,
                ), true),
            ),
            'Purchase Order' => array(
                'content' => $this->renderPartial('_viewPurchaseOrder', array(
                    'purchaseOrder' => $purchaseOrder,
                    'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
                ), true),
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab_cash',
    )); ?>
</div>

<br />

<table>
    <thead>
        <tr>
            <th>Branch</th>
            <th>Retail</th>
            <th>Wholesale</th>
            <!--<th>Sale Order</th>-->
            <th>Total</th>
        </tr>                    
    </thead>
    <tbody>
        <?php $retailGrandTotal = '0.00'; ?>
        <?php $wholesaleGrandTotal = '0.00'; ?>
        <?php //$saleOrderGrandTotal = '0.00'; ?>
        <?php $branchGrandTotal = '0.00'; ?>
        <?php foreach ($branches as $branch): ?>
            <?php $retailTotal = isset($cashDailySummary['retail'][$branch->id]) ? $cashDailySummary['retail'][$branch->id] : '0.00'; ?>
            <?php $wholeSaleTotal = isset($cashDailySummary['wholesale'][$branch->id]) ? $cashDailySummary['wholesale'][$branch->id] : '0.00'; ?>
            <?php //$saleOrderTotal = isset($cashDailySummary['saleorder'][$branch->id]) ? $cashDailySummary['saleorder'][$branch->id] : '0.00'; ?>
            <?php $branchTotal = $retailTotal + $wholeSaleTotal; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $retailTotal)), array(
                        'transactionInfo', 
                        'branchId' => $branch->id,
                        'transactionDate' => $transactionDate,
                        'transactionType' => 1,
                    ), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $wholeSaleTotal)), array(
                        'transactionInfo', 
                        'branchId' => $branch->id,
                        'transactionDate' => $transactionDate,
                        'transactionType' => 2,
                    ), array('target' => '_blank')); ?>
                </td>
<!--                <td style="text-align: right">
                    <?php /*echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleOrderTotal)), array(
                        'transactionInfo', 
                        'branchId' => $branch->id,
                        'transactionDate' => $transactionDate,
                        'transactionType' => 3,
                    ), array('target' => '_blank'));*/ ?>
                </td>-->
                <td style="text-align: right">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $branchTotal)), array(
                        'transactionInfo', 
                        'branchId' => $branch->id,
                        'transactionDate' => $transactionDate,
                        'transactionType' => 5,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>
            <?php $retailGrandTotal += $retailTotal; ?>
            <?php $wholesaleGrandTotal += $wholeSaleTotal; ?>
            <?php //$saleOrderGrandTotal += $saleOrderTotal; ?>
            <?php $branchGrandTotal += $branchTotal; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $retailGrandTotal)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $wholesaleGrandTotal)); ?></td>
            <!--<td style="text-align: right"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleOrderGrandTotal)); ?></td>-->
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $branchGrandTotal)); ?></td>
        </tr>
    </tfoot>
</table>
<?php echo CHtml::endForm(); ?>