<?php

$this->breadcrumbs = array(
    'Body Repair Transactions' => array('admin'),
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
                    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/admin', array('class' => 'button cbutton left', 'style' => 'margin-right:10px')) ?>

                    <?php if ($model->status !== 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
                        <?php if (count($invoices) == 0): ?>
                            <?php if (Yii::app()->user->checkAccess("bodyRepairEdit")): ?>
                                <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit Customer Data', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/update?id=' . $model->id, array('class' => 'button cbutton left', 'style' => 'margin-right:10px')) ?>
                            <?php endif; ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Product & Service', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/addProductService?registrationId=' . $model->id, array('class' => 'button success left', 'style' => 'margin-right:10px')) ?>
                        <?php endif; ?>
                    
                        <?php if (Yii::app()->user->checkAccess("bodyRepairSupervisor") && count($invoices) > 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-edit"></span>Revisi Customer Data', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/update?id=' . $model->id, array('class' => 'button cbutton left', 'style' => 'margin-right:10px')) ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Revisi Product & Service', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/addProductService?registrationId=' . $model->id, array('class' => 'button success left', 'style' => 'margin-right:10px')) ?>
                        <?php endif; ?>

                        <?php if (empty($model->sales_order_number)): ?>
                            <?php echo CHtml::button('Generate Sales Order', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'class' => 'button cbutton left',
                                'style' => 'margin-right:10px',
                                'disabled' => $model->sales_order_number == null ? false : true,
                                'onclick' => ' 
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('generateSalesOrder', array('id' => $model->id)) . '",
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            alert("Sales Order Succesfully Generated");
                                            location.reload();
                                        },
                                    })
                                '
                            )); ?>
                        <?php endif; ?>

                        <?php
                        $servicesReg = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));
                        $quickServicesReg = RegistrationQuickService::model()->findByAttributes(array('registration_transaction_id' => $model->id));
                        ?>
                    
                        <?php if (count($model->registrationServices) > 0 && empty($model->work_order_number)): ?>
                            <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Work Order', Yii::app()->baseUrl . '/frontDesk/bodyRepairRegistration/generateWorkOrder?id=' . $model->id, array(
                                'class' => 'button success left', 
                                'style' => 'margin-right:10px'
                            )); ?>
                        <?php endif; ?>

                        <?php if (empty($invoices)): ?>
                            <?php if (!empty($model->registrationServices) && (!empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php elseif (!empty($model->registrationServices) && empty($model->registrationProducts)): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php elseif (empty($model->registrationServices) && !empty($model->registrationProducts) && $model->getTotalQuantityMovementLeft() == 0): ?>
                                <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', Yii::app()->baseUrl . '/transaction/invoiceHeader/create?registrationId=' . $model->id, array(
                                    'class' => 'button success left', 
                                    'style' => 'margin-right:10px'
                                )); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess("bodyRepairCreate") || Yii::app()->user->checkAccess("bodyRepairEdit")): ?>
                            <?php echo CHtml::button('Show Realization', array(
                                'id' => 'real-button',
                                'name' => 'Real',
                                'class' => 'button cbutton left',
                                'onclick' => 'window.location.href = "showRealization?id=' . $model->id . '";'
                            )); ?>
                        <?php endif; ?>
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

        <div class="detail">
            <fieldset>
                <legend>Details</legend>
                <?php
                $tabsArray = array();
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
                $tabsArray['Damage'] =array(
                    'id'=>'damage',
                    'content'=>$this->renderPartial('_viewDamages', array(
                        'damages'=>$damages,
                        'model'=>$model
                    ),TRUE)
                );
                $tabsArray['Insurance Data'] = array(
                    'id'=>'insuranceData',
                    'content'=>$this->renderPartial('_viewInsurances', array(
                        'insurances'=>$insurances,
                        'model'=>$model
                    ),TRUE)
                );
                $tabsArray['Progress Service'] = array(
                    'id'=>'progressService',
                    'content'=>$this->renderPartial('_viewProgress', array(
                        'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
                        'model'=>$model
                    ),TRUE)
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
    
    <div>
        <?php if (Yii::app()->user->checkAccess("bodyRepairSupervisor") && $model->status !== 'Finished' && $model->status !== 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/frontDesk/bodyRepairRegistration/cancel", "id" => $model->id), array(
                'class' => 'button alert left', 
                'style' => 'margin-left:10px', 
            )); ?>
        <?php endif; ?>

        <?php if (empty($model->work_order_number) && $model->status !== 'Pending' && empty($model->sales_order_number)): ?>
            <?php echo CHtml::link('<span class="fa fa-bookmark"></span>Pending', Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/pendingOrder?id=' . $model->id, array('class'=>'button secondary right', 'style' => 'margin-right:10px')); ?>
        <?php endif; ?>
        <?php if (!empty($model->work_order_number) && $model->total_service > 0): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Work Order', Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/pdfWorkOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px')); ?>
        <?php endif; ?>
        <?php if (!empty($model->sales_order_number) && $model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Sales Order', Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/pdfSaleOrder?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px')); ?>
        <?php endif; ?>
        <?php if ($model->status !== 'Finished'): ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Estimasi', Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/pdf?id=' . $model->id, array('class'=>'button warning right', 'style' => 'margin-right:10px')); ?>
        <?php endif; ?>
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