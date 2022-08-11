<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">
            <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>
            <?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $model->id)); ?>
            <div class="row">
                <div class="large-12 columns">
                    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Registration', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/admin', array('class' => 'button cbutton left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
             
                    <?php if ($model->status != 'Finished'): ?>
                        <?php echo CHtml::submitButton('Finish Transaction', array('name' => 'SubmitFinish', 'confirm' => 'Are you sure you want to finish this transaction?', 'class' => 'button warning right', 'style' => 'margin-right:10px')); ?>
                        <?php echo CHtml::submitButton('Vehicle Off Premise', array('name' => 'SubmitOffPremise', 'confirm' => 'Are you sure you want to set this vehice off-premise?', 'class' => 'button success right', 'style' => 'margin-right:10px')); ?>
                        
                        <?php //if (count($invoices) == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit Customer Data', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/update?id=' . $model->id, array('class' => 'button cbutton left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Product & Service', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/addProductService?registrationId=' . $model->id, array('class' => 'button success left', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))) ?>
                        <?php //endif; ?>

                        <?php if (Yii::app()->user->checkAccess("generalRepairCreate")  && $model->status !== 'Finished'): ?>
                            <?php echo CHtml::button('Generate Sales Order', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'class' => 'button cbutton left',
                                'style' => 'margin-right:10px',
//                                'disabled' => $model->sales_order_number == null ? false : true,
                                'onclick' => '$.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('generateSalesOrder', array('id' => $model->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        alert("Sales Order Succesfully Generated");
                                        location.reload();
                                    },
                                })'
                            )); ?>
                        <?php endif; ?>

                        <?php
                        $servicesReg = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $model->id, 'is_body_repair' => 0));
                        $quickServicesReg = RegistrationQuickService::model()->findByAttributes(array('registration_transaction_id' => $model->id));
                        ?>
                    
                        <?php if (count($model->registrationServices) > 0 && $model->status !== 'Finished' && (Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))): ?>
                            <?php echo CHtml::button('Generate Work Order', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'class' => 'button cbutton left',
                                'style' => 'margin-right:10px',
                                'onclick' => ' 
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('generateWorkOrder', array('id' => $model->id)) . '",
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            alert("Work Order Succesfully Generated");
                                            location.reload();
                                        },
                                    })
                                '
                            )); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if (Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")): ?>
                        <?php echo CHtml::button('Show Realization', array(
                            'id' => 'real-button',
                            'name' => 'Real',
                            'class' => 'button cbutton left',
                            'onclick' => 'window.location.href = "showRealization?id=' . $model->id . '";'
                        )); ?>
                    <?php endif; ?>
                    
                    <?php //if (!empty($model->sales_order_number) && $model->status !== 'Finished' && (Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"))): ?>
                        <?php echo CHtml::button('Generate Invoice', array(
                            'id' => 'invoice-button',
                            'name' => 'Invoice',
                            'class' => 'button cbutton left',
                            'style' => 'margin-left:10px',
                            'onclick' => '$.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('generateInvoice', array('id' => $model->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) {
                                    alert("Invoice Succesfully Generated");
                                    location.reload();
                                },
                            })'
                        )); ?>
                    
                    <?php //endif; ?>
                </div>
            </div>

            <h1>View Registration Transaction #<?php echo $model->transaction_number; ?></h1>

            <fieldset>
                <legend>Information</legend>
                <div class="row" style="height: 550px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Registration' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_viewRegistration', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Billing Estimation' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_viewBilling', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Customer Info' => array(
                                'id' => 'info3',
                                'content' => $this->renderPartial('_viewCustomer', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Vehicle Info' => array(
                                'id' => 'info4',
                                'content' => $this->renderPartial('_viewVehicle', array(
                                    'model' => $model,
                                ), true)
                            ),
                            'Messages' => array(
                                'id' => 'info5',
                                'content' => $this->renderPartial('_viewMemo', array(
                                    'registrationMemos' => $registrationMemos,
                                    'memo' => $memo,
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
    
    <hr /><br />
    
    <div class="detail">
        <fieldset>
            <legend>Details</legend>
            <?php
            $tabsArray = array();
            $tabsArray['Quick Service'] = array(
                'id' => 'quickService',
                'content' => $this->renderPartial('_viewQuickService', array(
                    'quickServices' => $quickServices,
                    'ccontroller' => $ccontroller,
                    'model' => $model
                ), TRUE)
            );
            $tabsArray['Service'] = array(
                'id' => 'service',
                'content' => $this->renderPartial('_viewServices', array(
                    'services' => $services
                ), TRUE)
            );
            $tabsArray['Product'] = array(
                'id' => 'product',
                'content' => $this->renderPartial('_viewProducts', array(
                    'products' => $products,
                    'model' => $model
                ), TRUE)
            );
            $tabsArray['History'] = array(
                'id' => 'history',
                'content' => $this->renderPartial('_viewHistory', array(
                    'model' => $model
                ), TRUE)
            );
            
            $tabsArray['Inspection'] = array(
                'id' => 'inspection',
                'content' => $this->renderPartial('_viewInspection', array(
                    'model' => $model
                ), TRUE)
            );
            
            if (Yii::app()->user->checkAccess("generalManager")) {
                $tabsArray['Journal'] = array(
                    'id' => 'journal',
                    'content' => $this->renderPartial('_viewJournal', array(
                        'model' => $model
                    ), TRUE)
                );
            }
            ?>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $tabsArray,
                // additional javascript options for the tabs plugin
                'options' => array('collapsible' => true),
            )); ?>
        </fieldset>
    </div>
    
    <div>
        <?php if (!empty($model->work_order_number) && $model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Work Order', Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/pdfWorkOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("frontDesk.generalRepairRegistration.admin"), 'target' =>'_blank')) ?>
        <?php endif; ?>
        <?php if (!empty($model->sales_order_number) && $model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Sales Order', Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/pdfSaleOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("frontDesk.generalRepairRegistration.admin"), 'target' =>'_blank')) ?>
        <?php endif; ?>
        <?php if ($model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Estimasi', Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/pdf?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("frontDesk.generalRepairRegistration.admin"), 'target' =>'_blank')) ?>
        <?php endif; ?>
        <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
    </div>
</div>

<?php echo IdempotentManager::generate(); ?>

<?php echo CHtml::endForm(); ?>
