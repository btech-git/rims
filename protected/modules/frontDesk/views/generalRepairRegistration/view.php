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
            <?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $model->id, 'user_id_cancelled' => null)); ?>
            <div class="row">
                <div class="large-12 columns">
                    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Registration', array("admin"), array(
                        'class' => 'button cbutton left', 
                        'style' => 'margin-right:10px', 
                        'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit") || Yii::app()->user->checkAccess("generalRepairView")
                    )); ?>
             
                    <?php if (!empty($model->work_order_number) && $model->total_service > 0): ?>
                        <?php echo CHtml::link('<span class="fa fa-print"></span> Print Work Order', array("pdfWorkOrder", "id" => $model->id), array(
                            'class'=>'button warning right', 
                            'style' => 'margin-right:10px', 
                            'target' =>'_blank',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>
                    <?php if (!empty($model->sales_order_number) && $model->status !== 'Finished'): ?>
                        <?php echo CHtml::link('<span class="fa fa-print"></span> Print Sales Order', array("pdfSaleOrder", "id" => $model->id), array(
                            'class'=>'button warning right', 
                            'style' => 'margin-right:10px', 
                            'target' =>'_blank',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>
                    <?php if ($model->status !== 'Finished'): ?>
                        <?php echo CHtml::link('<span class="fa fa-print"></span> Print Estimasi', array("pdf", "id" => $model->id), array(
                            'class'=>'button warning right', 
                            'style' => 'margin-right:10px', 
                            'target' =>'_blank',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>
                    
                    <?php if ($model->status !== 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
                        <?php if (count($invoices) == 0): ?>
                            <?php if (Yii::app()->user->checkAccess("generalRepairEdit")): ?>
                                <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit Customer Data', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/update?id=' . $model->id, array(
                                    'class' => 'button cbutton left', 
                                    'style' => 'margin-right:10px', 
                                    'visible' => Yii::app()->user->checkAccess("generalRepairEdit")
                                )); ?>
                            <?php endif; ?>

                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Product & Service', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/addProductService?registrationId=' . $model->id, array(
                                'class' => 'button success left', 
                                'style' => 'margin-right:10px', 
                                'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                            )); ?>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess("generalRepairSupervisor") && count($invoices) > 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-edit"></span>Revisi Customer Data', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/update?id=' . $model->id, array(
                                'class' => 'button cbutton left', 
                                'style' => 'margin-right:10px'
                            )); ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Revisi Product & Service', Yii::app()->baseUrl . '/frontDesk/generalRepairRegistration/addProductService?registrationId=' . $model->id, array(
                                'class' => 'button success left', 
                                'style' => 'margin-right:10px'
                            )); ?>
                        <?php endif; ?>

                        <?php if (empty($model->sales_order_number) && !empty($model->registrationProducts)): ?>
                            <?php echo CHtml::button('Generate Sales Order', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'class' => 'button cbutton left',
                                'style' => 'margin-right:10px',,
                                'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit"),
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
                    
                        <?php if (count($model->registrationServices) > 0 && empty($model->work_order_number)): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span> Generate Work Order', array("generateWorkOrder", "id" => $model->id), array(
                                'class' => 'button success left', 
                                'style' => 'margin-right:10px',
                                'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                            )); ?>
                        <?php endif; ?>
                    
                        <?php if (empty($invoices) /*&& !($model->status == 'Approved' || $model->status == 'Finished' || $model->status == 'CANCELLED!!!')*/): ?>
                            <?php if (!empty($model->registrationServices) && (!empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', array("/transaction/invoiceHeader/create", "registrationId" => $model->id), array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px',
                                    'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                                )); ?>
                            <?php elseif (!empty($model->registrationServices) && empty($model->registrationProducts)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', array("/transaction/invoiceHeader/create", "registrationId" => $model->id), array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px',
                                    'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                                )); ?>
                            <?php elseif (empty($model->registrationServices) && !empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', array("/transaction/invoiceHeader/create", "registrationId" => $model->id), array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px',
                                    'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                                )); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")): ?>
                            <?php echo CHtml::button('Show Realization', array(
                                'id' => 'real-button',
                                'name' => 'Real',
                                'class' => 'button cbutton left',
                                'onclick' => 'window.location.href = "showRealization?id=' . $model->id . '";',
                                'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                            )); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if (Yii::app()->user->checkAccess("generalRepairSupervisor")): ?>
                        <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/frontDesk/generalRepairRegistration/cancel", "id" => $model->id), array(
                            'class' => 'button alert left', 
                            'style' => 'margin-left:10px',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>

                    <?php //if ($model->status == 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
                        <?php /*echo CHtml::link('Status Kendaraan', array("/frontDesk/generalRepairRegistration/updateLocation", "id" => $model->id, "vehicleId" => $model->vehicle_id), array(
                            'class' => 'button warning left', 
                            'style' => 'margin-left:10px',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); */?>
                    <?php //endif; ?>

                    <?php if (!empty($invoices) && (!empty($model->sales_order_number) || !empty($model->work_order_number))): ?>
                        <?php echo CHtml::submitButton('Finish Transaction', array(
                            'name' => 'SubmitFinish', 
                            'confirm' => 'Are you sure you want to finish this transaction?', 
                            'class' => 'button info right', 
                            'style' => 'margin-right:10px',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>

                    <?php if ($model->service_status !== 'Done' && $model->total_service > 0): ?>
                        <?php echo CHtml::submitButton('Finish Service', array(
                            'name' => 'SubmitService', 
                            'confirm' => 'Are you sure you want to finish this services?', 
                            'class' => 'button info right', 
                            'style' => 'margin-right:10px',
                            'visible' => Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")
                        )); ?>
                    <?php endif; ?>
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
            $tabsArray['Movement'] = array(
                'id' => 'movement',
                'content' => $this->renderPartial('_viewMovement', array(
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
            
            ?>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $tabsArray,
                // additional javascript options for the tabs plugin
                'options' => array('collapsible' => true),
            )); ?>
        </fieldset>
    </div>
</div>

<?php echo CHtml::endForm(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>