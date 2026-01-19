<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Cash Daily'=>array('admin'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List RegistrationService', 'url'=>array('index')),
//	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Cash Daily Summary</h1>
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
                                <?php echo CHtml::submitButton('Show', array(
                                    'onclick' => '$("#CurrentSort").val(""); return true;', 
                                    'class'=>'button info right'
                                )); ?>
                                <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php echo CHtml::endForm(); ?>
            
            <hr />
            
            <?php echo $this->renderPartial('_form', array(
                'paymentTypes' => $paymentTypes,
                'paymentInWholesale' => $paymentInWholesale,
                'paymentInWholesaleDataProvider' => $paymentInWholesaleDataProvider,
                'paymentOut' => $paymentOut,
                'paymentOutDataProvider' => $paymentOutDataProvider,
                'cashTransaction' => $cashTransaction,
                'cashTransactionInDataProvider' => $cashTransactionInDataProvider,
                'cashTransactionOutDataProvider' => $cashTransactionOutDataProvider,
                'branchId' => $branchId,
                'transactionDate' => $transactionDate,
                'paymentInRetailResultSet' => $paymentInRetailResultSet,
                'paymentInRetailList' => $paymentInRetailList,
                'existingDate' => $existingDate,
                'saleOrder' => $saleOrder,
                'saleOrderDataProvider' => $saleOrderDataProvider,
                'retailTransactionHead' => $retailTransactionHead,
                'retailTransactionHeadDataProvider' => $retailTransactionHeadDataProvider,
                'retailTransaction1' => $retailTransaction1,
                'retailTransaction1DataProvider' => $retailTransaction1DataProvider,
                'retailTransaction2' => $retailTransaction2,
                'retailTransaction2DataProvider' => $retailTransaction2DataProvider,
                'retailTransaction4' => $retailTransaction4,
                'retailTransaction4DataProvider' => $retailTransaction4DataProvider,
                'retailTransaction5' => $retailTransaction5,
                'retailTransaction5DataProvider' => $retailTransaction5DataProvider,
                'retailTransaction6' => $retailTransaction6,
                'retailTransaction6DataProvider' => $retailTransaction6DataProvider,
                'retailTransaction8' => $retailTransaction8,
                'retailTransaction8DataProvider' => $retailTransaction8DataProvider,
                'wholesaleTransaction' => $wholesaleTransaction,
                'wholesaleTransactionDataProvider' => $wholesaleTransactionDataProvider,
                'purchaseOrder' => $purchaseOrder,
                'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
                'transactionJournal' => $transactionJournal,
                'transactionJournalDataProvider' => $transactionJournalDataProvider,
                'cashDailySummary' => $cashDailySummary,
                'branches' => $branches,
            )); ?>
        </div>
    </div>
</div>
