<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">Tanggal</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'TransactionDate',
                                            'value' => $transactionDate,
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <!-- END COLUMN 6-->
                        <div class="medium-6 columns">
                            <div class="field">
                                <?php //echo CHtml::resetButton('Clear', array('class'=>'button secondary')); ?>
                                <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'class'=>'button info right')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="row">
                <p><h2>Payment In Retail</h2></p>
                <?php $this->renderPartial('_detailPaymentInRetail', array(
                    'paymentTypes' => $paymentTypes,
//                    'branchId' => $branchId,
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
//                    'branchId' => $branchId,
                    'transactionDate' => $transactionDate,
                )); ?>
            </div>
            
            <div class="row">
                <p><h2>Payment Out</h2></p>
                <?php $this->renderPartial('_detailPaymentOut', array(
                    'paymentOut' => $paymentOut,
                    'paymentOutDataProvider' => $paymentOutDataProvider,
//                    'branchId' => $branchId,
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
//                                'branchId' => $branchId,
                                'transactionDate' => $transactionDate,
                            ), true),
                        ),
                        'Transaction Out' => array(
                            'content' => $this->renderPartial('_detailCashTransactionOut', array(
                                'cashTransaction' => $cashTransaction,
                                'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
//                                'branchId' => $branchId,
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
            
            <?php /*if (Yii::app()->user->checkAccess('cashDailyTransactionReport')): ?>
                <div class="row">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Retail HO' => array(
                                'content' => $this->renderPartial('_viewRetailTransactionHead', array(
                                    'retailTransactionHead' => $retailTransactionHead,
                                    'retailTransactionHeadDataProvider' => $retailTransactionHeadDataProvider,
                                ), true),
                            ),
                            'Retail R-1' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction1', array(
                                    'retailTransaction1' => $retailTransaction1,
                                    'retailTransaction1DataProvider' => $retailTransaction1DataProvider,
                                ), true),
                            ),
                            'Retail R-2' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction2', array(
                                    'retailTransaction2' => $retailTransaction2,
                                    'retailTransaction2DataProvider' => $retailTransaction2DataProvider,
                                ), true),
                            ),
                            'Retail R-4' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction4', array(
                                    'retailTransaction4' => $retailTransaction4,
                                    'retailTransaction4DataProvider' => $retailTransaction4DataProvider,
                                ), true),
                            ),
                            'Retail R-5' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction5', array(
                                    'retailTransaction5' => $retailTransaction5,
                                    'retailTransaction5DataProvider' => $retailTransaction5DataProvider,
                                ), true),
                            ),
                            'Retail R-6' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction6', array(
                                    'retailTransaction6' => $retailTransaction6,
                                    'retailTransaction6DataProvider' => $retailTransaction6DataProvider,
                                ), true),
                            ),
                            'Retail R-8' => array(
                                'content' => $this->renderPartial('_viewRetailTransaction8', array(
                                    'retailTransaction8' => $retailTransaction8,
                                    'retailTransaction8DataProvider' => $retailTransaction8DataProvider,
                                ), true),
                            ),
                            'Sales Wholesale' => array(
                                'content' => $this->renderPartial('_viewWholesaleTransaction', array(
                                    'wholesaleTransaction' => $wholesaleTransaction,
                                    'wholesaleTransactionDataProvider' => $wholesaleTransactionDataProvider,
                                ), true),
                            ),
                            'Sales Order' => array(
                                'content' => $this->renderPartial('_viewSaleOrder', array(
                                    'saleOrder' => $saleOrder,
                                    'saleOrderDataProvider' => $saleOrderDataProvider,
                                ), true),
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab_transaction',
                    )); ?>
                </div>
            <?php endif; */?>
            
            <table>
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Retail</th>
                        <th>Wholesale</th>
                        <th>Sale Order</th>
                        <th>Total</th>
                    </tr>                    
                </thead>
                <tbody>
                    <?php $retailGrandTotal = '0.00'; ?>
                    <?php $wholesaleGrandTotal = '0.00'; ?>
                    <?php $saleOrderGrandTotal = '0.00'; ?>
                    <?php $branchGrandTotal = '0.00'; ?>
                    <?php foreach ($branches as $branch): ?>
                        <?php $retailTotal = isset($cashDailySummary['retail'][$branch->id]) ? $cashDailySummary['retail'][$branch->id] : '0.00'; ?>
                        <?php $wholeSaleTotal = isset($cashDailySummary['wholesale'][$branch->id]) ? $cashDailySummary['wholesale'][$branch->id] : '0.00'; ?>
                        <?php $saleOrderTotal = isset($cashDailySummary['saleorder'][$branch->id]) ? $cashDailySummary['saleorder'][$branch->id] : '0.00'; ?>
                        <?php $branchTotal = $retailTotal + $wholeSaleTotal + $saleOrderTotal; ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $retailTotal)); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $wholeSaleTotal)); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleOrderTotal)); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $branchTotal)); ?></td>
                        </tr>
                        <?php $retailGrandTotal += $retailTotal; ?>
                        <?php $wholesaleGrandTotal += $wholeSaleTotal; ?>
                        <?php $saleOrderGrandTotal += $saleOrderTotal; ?>
                        <?php $branchGrandTotal += $branchTotal; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align: right">Total</td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $retailGrandTotal)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $wholesaleGrandTotal)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleOrderGrandTotal)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $branchGrandTotal)); ?></td>
                    </tr>
                </tfoot>
            </table>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
