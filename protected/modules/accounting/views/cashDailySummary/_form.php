<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php echo CHtml::beginForm(); ?>

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
                                        <?php //echo CHtml::textField('TransactionDate', $transactionDate); ?>
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'TransactionDate',
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
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">Branch</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END COLUMN 6-->
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">User</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php //echo CHtml::hiddenField($cashDailySummary,'user_id'); ?>
                                        <?php echo CHtml::encode(Users::model()->findByPk(Yii::app()->user->id)->username); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                            <?php echo CHtml::resetButton('Clear'); ?>
                        </div>

                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="row">
                <p><h2>Payment In Retail</h2></p>
                <?php $this->renderPartial('_detailPaymentInRetail', array(
//                    'cashDailySummary' => $cashDailySummary,
//                    'paymentTypes' => $paymentTypes,
//                    'paymentInRetail' => $paymentInRetail,
                    'paymentInRetailDataProvider' => $paymentInRetailDataProvider,
                    'branchId' => $branchId,
                    'transactionDate' => $transactionDate,
                )); ?>
            </div>
            
            <div class="row">
                <p><h2>Payment In Non Retail</h2></p>
                <?php $this->renderPartial('_detailPaymentInWholesale', array(
//                    'cashDailySummary' => $cashDailySummary,
//                    'paymentTypes' => $paymentTypes,
                    'paymentInWholesale' => $paymentInWholesale,
                    'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
                    'branchId' => $branchId,
                    'transactionDate' => $transactionDate,
                )); ?>
            </div>
            
            <div class="row">
                <p><h2>Payment Out</h2></p>
                <?php $this->renderPartial('_detailPaymentOut', array(
//                    'cashDailySummary' => $cashDailySummary,
//                    'paymentTypes' => $paymentTypes,
//                    'pageNumber' => $pageNumber,
                    'paymentOut' => $paymentOut,
                    'paymentOutDataProvider' => $paymentOutDataProvider,
                    'branchId' => $branchId,
                    'transactionDate' => $transactionDate,
                )); ?>
            </div>
            
            <div class="row">
                <p><h2>Cash Transaction</h2></p>
                <?php $this->renderPartial('_detailCashTransaction', array(
//                    'cashDailySummary' => $cashDailySummary,
//                    'pageNumber' => $pageNumber,
                    'cashTransaction' => $cashTransaction,
                    'cashTransactionDataProvider' => $cashTransactionDataProvider,
                    'branchId' => $branchId,
                    'transactionDate' => $transactionDate,
                )); ?>
            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>