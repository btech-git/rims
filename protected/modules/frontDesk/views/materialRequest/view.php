<?php
/* @var $this MaterialRequestController */
/* @var $materialRequest MaterialRequest */

$this->breadcrumbs = array(
    'Material Requests' => array('admin'),
    $materialRequest->id,
);

$this->menu = array(
    array('label' => 'List Material Request', 'url' => array('index')),
    array('label' => 'Create Material Request', 'url' => array('create')),
    array('label' => 'Update Material Request', 'url' => array('update', 'id' => $materialRequest->id)),
    array(
        'label' => 'Delete Material Request',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $materialRequest->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage Material Request', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Permintaan Bahan', Yii::app()->baseUrl . '/frontDesk/materialRequest/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("frontDesk.materialRequest.admin")
        ));  ?>

        <?php //if ($materialRequest->status_document != 'Approved' && $materialRequest->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/frontDesk/materialRequest/update?id=' . $materialRequest->id, array(
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
                'visible' => Yii::app()->user->checkAccess("materialRequestEdit")
            )); ?>
        <?php //endif; ?>

        <?php if ($materialRequest->status_document == "Draft" && Yii::app()->user->checkAccess("materialRequestApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/frontDesk/materialRequest/updateApproval?headerId=' . $materialRequest->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($materialRequest->status_document != "Draft" && Yii::app()->user->checkAccess("materialRequestSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/frontDesk/materialRequest/updateApproval?headerId=' . $materialRequest->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>
        
        <?php if (Yii::app()->user->checkAccess("materialRequestSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/frontDesk/materialRequest/cancel", "id" => $materialRequest->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>

        <h1>View Permintaan Bahan #<?php echo $materialRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $materialRequest,
            'attributes' => array(
                'transaction_number',
                'dateTime',
                array(
                    'name' => 'registration_transaction_id', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : CHTml::link($materialRequest->registrationTransaction->transaction_number, array($materialRequest->registrationTransaction->repair_type == "GR" ? "/frontDesk/generalRepairRegistration/view" : "/frontDesk/bodyRepairRegistration/view", "id" => $materialRequest->registration_transaction_id), array('target' => 'blank')),
                    'type'=>'raw',
                ),
                array(
                    'label' => 'WO #', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->work_order_number
                ),
                array(
                    'name' => 'branch_id', 
                    'value' => $materialRequest->branch->name
                ),
                array(
                    'label' => 'Tanggal WO ', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->transaction_date
                ),
                array(
                    'label' => 'Customer', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->customer->name
                ),
                array(
                    'label' => 'Plate #', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->vehicle->plate_number
                ),
                array(
                    'label' => 'Vehicle', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->vehicle->carMakeModelSubCombination
                ),
                array(
                    'label' => 'Color', 
                    'value' => empty($materialRequest->registration_transaction_id) ? "" : $materialRequest->registrationTransaction->vehicle->color->name
                ),
                'status_document',
                'status_progress',
                'note',
                array(
                    'name' => 'user_id', 
                    'value' => $materialRequest->user->username
                ),
            ),
        )); ?>

    </div>
</div>

<hr />

<div class="detail">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial('_viewDetail', array(
                    'model' => $materialRequest
                ), true)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial(
                    '_viewDetailApproval',
                    array('model' => $materialRequest), true)
            ),

            'Detail Movement Out' => array(
                'id' => 'test3',
                'content' => $this->renderPartial('_viewDetailMovementOut', array(
                    'model' => $materialRequest
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