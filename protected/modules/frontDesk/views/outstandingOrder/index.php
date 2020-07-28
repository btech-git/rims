<?php
$this->breadcrumbs=array(
	'Outstanding Order'=>array('index'),
);

Yii::app()->clientScript->registerScript('report', '
	 $("#tanggal_mulai").val("' . $tanggal_mulai . '");
     $("#tanggal_sampai").val("' . $tanggal_sampai . '");
    
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>


	
<div id="maincontent">
<div class="clearfix page-action">
     <div class="grid-view"></div>
        <fieldset>
            <legend>Outstanding Orders</legend>
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
                                <span class="prefix">Status Document</span>
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
                                <?php echo CHtml::dropDownlist('MainBranch', $mainBranch, CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')),'id','name'), array('empty'=>'-- All Main Branch --')); ?>
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
                        'Purchase Order' => array(
                            'content' => $this->renderPartial(
                                '_viewPurchase',
                                array(
                                    'purchaseOrderDataProvider' => $purchaseOrderDataProvider, 
                                    'purchaseOrder' => $purchaseOrder
                                ), true
                            )
                        ),
                        'Sales Order' => array(
                            'content' => $this->renderPartial(
                                '_viewSale',
                                array(
                                    'saleOrderDataProvider' => $saleOrderDataProvider, 
                                    'saleOrder' => $saleOrder
                                ), true
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
        </fieldset>
     </div>
 </div>