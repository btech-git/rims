<?php
$this->breadcrumbs=array(
	'Pending Request'=>array('index'),
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
            <legend>Pending Requests</legend>
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
                                <span class="prefix">Status Document </span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('status_document', $status_document, array(
                                    'Draft'=>'Draft',
                                    'Approved' => 'Approved',
//                                    'Revised' => 'Revised',
//                                    'Rejected'=>'Rejected'
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
                                <span class="prefix">Approval Status</span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('destination_approval_status', $destination_approval_status, array(
                                    '0' => 'Pending',
                                    '1' => 'Approved',
//                                    '2' => 'Rejected',
                                ), array('empty'=>'-- All Approval Status --')); ?>
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
                                <span class="prefix">Requester Branch</span>
                            </div>
                             <div class="small-8 columns">
                                <?php echo CHtml::dropDownlist('RequesterBranch', $requesterBranch, CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')),'id','name'), array('empty'=>'-- All Requester Branch --')); ?>
                            </div>
                        </div>
                    </div>
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
                        'Transfer Request' => array(
                            'content' => $this->renderPartial('_viewTransfer', array(
                                'transferDataProvider' => $transferDataProvider, 
                                'transfer' => $transfer
                            ), true)
                        ),
                        'Sent Request' => array(
                            'content' => $this->renderPartial('_viewSent', array(
                                'sentDataProvider' => $sentDataProvider, 
                                'sent' => $sent
                            ), true)
                        ),
                        'Cuti Karyawan' => array(
                            'content' => $this->renderPartial('_viewEmployeeDayoff', array(
                                'employeeDayoffDataProvider' => $employeeDayoffDataProvider,
                                'employeeDayoff' => $employeeDayoff,
                            ), true)
                        ),
                        'Maintenance Request' => array(
                            'content' => $this->renderPartial('_viewMaintenanceRequest', array(
                                'maintenanceRequestHeader' => $maintenanceRequestHeader,
                                'maintenanceRequestHeaderDataProvider' => $maintenanceRequestHeaderDataProvider,
                            ), true)
                        ),
                        'Material Request' => array(
                            'content' => $this->renderPartial('_viewMaterialRequest', array(
                                'materialRequestHeader' => $materialRequestHeader,
                                'materialRequestHeaderDataProvider' => $materialRequestHeaderDataProvider,
                            ), true)
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