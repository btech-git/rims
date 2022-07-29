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
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Material Request', Yii::app()->baseUrl . '/frontDesk/materialRequest/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("frontDesk.materialRequest.admin")
        ));  ?>

        <?php if ($materialRequest->status_document != 'Approved' && $materialRequest->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/frontDesk/materialRequest/update?id=' . $materialRequest->id, array(
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
                'visible' => Yii::app()->user->checkAccess("frontDesk.materialRequest.update")
            )); ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/frontDesk/materialRequest/updateApproval?headerId=' . $materialRequest->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.materialRequest.updateApproval"))) ?>
        <?php endif; ?>

        <h1>View Permintaan Bahan #<?php echo $materialRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $materialRequest,
            'attributes' => array(
                'transaction_number',
                'dateTime',
                array(
                    'name' => 'registration_transaction_id', 
                    'value' => $materialRequest->registrationTransaction->transaction_number
                ),
                array(
                    'label' => 'WO #', 
                    'value' => $materialRequest->registrationTransaction->work_order_number
                ),
                array(
                    'name' => 'branch_id', 
                    'value' => $materialRequest->branch->name
                ),
                array(
                    'label' => 'Tanggal WO ', 
                    'value' => $materialRequest->registrationTransaction->transaction_date
                ),
                array(
                    'label' => 'Customer', 
                    'value' => $materialRequest->registrationTransaction->customer->name
                ),
                array(
                    'label' => 'Plate #', 
                    'value' => $materialRequest->registrationTransaction->vehicle->plate_number
                ),
                array(
                    'label' => 'Vehicle', 
                    'value' => $materialRequest->registrationTransaction->vehicle->carMakeModelSubCombination
                ),
                array(
                    'label' => 'Color', 
                    'value' => $materialRequest->registrationTransaction->vehicle->color->name
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
	

