<?php
$this->breadcrumbs=array(
    'Cancelled Transactions'=>array('index'),
);

Yii::app()->clientScript->registerScript('report', '
     $("#StartDate").val("' . $startDate . '");
     $("#EndDate").val("' . $endDate . '");
    
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>


	
<div id="maincontent">
<div class="clearfix page-action">
     <div class="grid-view"></div>
        <fieldset>
            <legend>Cancelled Transactions</legend>
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
                                    'name'=>'StartDate',
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
                                    'name'=>'EndDate',
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
                                <span class="prefix">Branch</span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')),'id','name'), array('empty'=>'-- All Requester Branch --')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
            <?php echo CHtml::endForm(); ?>
            <br />
            <div>
                <?php /*$this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'General Repair' => array(
                            'content' => $this->renderPartial('_viewGeneralRepair', array(
                                'generalRepairDataProvider' => $generalRepairDataProvider, 
                            ), true)
                        ),
                        'Body Repair' => array(
                            'content' => $this->renderPartial('_viewBodyRepair', array(
                                'bodyRepairDataProvider' => $bodyRepairDataProvider, 
                            ), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'view_tab',
                ));*/ ?>
            </div>
        </fieldset>
     </div>
 </div>