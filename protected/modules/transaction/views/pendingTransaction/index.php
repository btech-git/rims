<?php
/* @var $this TransactionDeliveryOrderController */
/* @var $model TransactionDeliveryOrder */

$this->breadcrumbs=array(
	'Pending Transaction'=>array('index'),
);

$this->menu=array(
	array('label'=>'List Pending Transaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('report', '
	 $("#tanggal_mulai").val("' . $tanggal_mulai . '");
     $("#tanggal_sampai").val("' . $tanggal_sampai . '");
    
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div id="maincontent">
<div class="clearfix page-action">
    <h1>Pending Transaction</h1>
     <div class="grid-view"></div>
        <fieldset>
            <legend>Pending Orders</legend>
            <div class="myForm" id="myForm">

            <?php echo CHtml::beginForm(array(''), 'get'); ?>
             <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-2 columns">
                                <span class="prefix">Tanggal </span>
                            </div>
                            <div class="small-5 columns">
                                 <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name'=>'tanggal_mulai',
                                    'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'placeholder'=>'Mulai',
                                    ),
                                )); ?>
                            </div>

                            <div class="small-5 columns">
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name'=>'tanggal_sampai',
                                    'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                        'changeMonth'=>true,
                                        'changeYear'=>true,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'placeholder'=>'Sampai',
                                    ),
                                )); ?>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Status Document </span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('status_document', $status_document, array(
                                    'Draft'=>'Draft',
                                    'Approved' => 'Approved',
                                    'Revised' => 'Revised',
                                    'Rejected'=>'Rejected'
                                ), array('empty'=>'-- All Status Document --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Main / Destination Branch</span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('MainBranch', $mainBranch, CHtml::listData(UserBranch::model()->findAllByAttributes(array('users_id' => Yii::app()->user->id)),'branch_id','branch.name'), array('empty'=>'-- All Main Branch --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
            <?php echo CHtml::endForm(); ?>
            <br />
            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Request Order' => array(
                            'content' => $this->renderPartial(
                                '_viewRequest',
                                array('requestDataProvider' => $requestDataProvider, 'request' => $request),
                                true
                            )
                        ),
                        'Purchase Order' => array(
                            'content' => $this->renderPartial(
                                '_viewPurchase',
                                array('purchaseDataProvider' => $purchaseDataProvider, 'purchase' => $purchase),
                                true
                            )
                        ),
                        'Sales Order' => array(
                            'content' => $this->renderPartial(
                                '_viewSales',
                                array('salesDataProvider' => $salesDataProvider, 'sales' => $sales),
                                true
                            )
                        ),
                        'Transfer Request' => array(
                            'content' => $this->renderPartial(
                                '_viewTransfer',
                                array('transferDataProvider' => $transferDataProvider, 'transfer' => $transfer),
                                true
                            )
                        ),
                        'Sent Request' => array(
                            'content' => $this->renderPartial(
                                '_viewSent',
                                array('sentDataProvider' => $sentDataProvider, 'sent' => $sent),
                                true
                            )
                        ),
                        'Consignment Out' => array(
                            'content' => $this->renderPartial(
                                '_viewConsignmentOut',
                                array('consignmentDataProvider' => $consignmentDataProvider, 'consignment' => $consignment),
                                true
                            )
                        ),
                        'Consignment In' => array(
                            'content' => $this->renderPartial(
                                '_viewConsignmentIn',
                                array('consignmentInDataProvider' => $consignmentInDataProvider, 'consignmentIn' => $consignmentIn),
                                true
                            )
                        ),
                        'Movement In' => array(
                            'content' => $this->renderPartial(
                                '_viewMovementIn',
                                array('movementInDataProvider' => $movementInDataProvider, 'movementIn' => $movementIn),
                                true
                            )
                        ),
                        'Movement Out' => array(
                            'content' => $this->renderPartial(
                                '_viewMovementOut',
                                array('movementDataProvider' => $movementDataProvider, 'movement' => $movement),
                                true
                            )
                        ),
                        'Adjustment Stock' => array(
                            'content' => $this->renderPartial(
                                '_viewStockAdjustment',
                                array('stockAdjustmentDataProvider' => $stockAdjustmentDataProvider, 'stockAdjustmentHeader' => $stockAdjustmentHeader),
                                true
                            )
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'view_tab',
                )); ?>
            </div>
<!--            <h2>Request Order</h2>

            <h2>Purchase Order</h2>

            <h2>Sales Order</h2>

            <h2>Transfer Request</h2>

            <h2>Sent Request</h2>

            <h2>Consignment Out</h2>

            <h2>Consignment In</h2>

            <h2>Movement In</h2>

            <h2>Movement Out</h2>-->

        </fieldset>
     </div>
 </div>