<?php
/* @var $this ReceivePartsController */
/* @var $receiveParts ReceiveParts */

$this->breadcrumbs = array(
    'Receive Parts Supply' => array('admin'),
    $receiveParts->id,
);

$this->menu = array(
    array('label' => 'List ReceiveParts', 'url' => array('index')),
    array('label' => 'Create ReceiveParts', 'url' => array('create')),
    array('label' => 'Update ReceiveParts', 'url' => array('update', 'id' => $receiveParts->id)),
    array('label' => 'Delete ReceiveParts', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $receiveParts->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ReceiveParts', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/frontDesk/receiveParts/admin', array(
            'class' => 'button cbutton right',
        ));  ?>

        <h1>Show Penerimaan Parts Supply #<?php echo $receiveParts->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $receiveParts,
            'attributes' => array(
                'transaction_number',
                'transaction_date',
                array(
                    'name' => 'registration_transaction_id', 
                    'value' => empty($receiveParts->registration_transaction_id) ? "" : CHTml::link($receiveParts->registrationTransaction->transaction_number, array($receiveParts->registrationTransaction->repair_type == "GR" ? "/frontDesk/generalRepairRegistration/view" : "/frontDesk/bodyRepairRegistration/view", "id" => $receiveParts->registration_transaction_id), array('target' => 'blank')),
                    'type'=>'raw',
                ),
                array(
                    'label' => 'WO #', 
                    'value' => empty($receiveParts->registration_transaction_id) ? "" : $receiveParts->registrationTransaction->work_order_number
                ),
                array(
                    'name' => 'branch_id', 
                    'value' => $receiveParts->branch->name
                ),
                array(
                    'label' => 'Customer', 
                    'value' => empty($receiveParts->registration_transaction_id) ? "" : $receiveParts->registrationTransaction->customer->name
                ),
                array(
                    'label' => 'Plate #', 
                    'value' => empty($receiveParts->registration_transaction_id) ? "" : $receiveParts->registrationTransaction->vehicle->plate_number
                ),
                array(
                    'label' => 'Vehicle', 
                    'value' => empty($receiveParts->registration_transaction_id) ? "" : $receiveParts->registrationTransaction->vehicle->carMakeModelSubCombination
                ),
                array(
                    'name' => 'transaction_type', 
                    'value' => $receiveParts->transaction_type,
                ),
                array(
                    'label' => 'Asuransi',
                    'name' => 'insurance_company_id',
                    'value' => CHtml::encode(CHtml::value($receiveParts, 'insuranceCompany.name')),
                ),
                'supplier_delivery_number',
                'status',
                'note',
                array(
                    'name' => 'user_id_created', 
                    'value' => $receiveParts->userIdCreated->username
                ),
                'created_datetime',
                array(
                    'name' => 'user_id_updated', 
                    'value' => CHtml::encode(CHtml::value($receiveParts, 'userIdUpdated.username')),
                ),
                'updated_datetime',
                array(
                    'name' => 'user_id_cancelled', 
                    'value' => CHtml::encode(CHtml::value($receiveParts, 'userIdCancelled.username')),
                ),
                'cancelled_datetime',
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
                    'receiveParts' => $receiveParts,
                    'receivePartsDetails' => $receivePartsDetails,
                ), true)
            ),
//            'Detail Movement Out' => array(
//                'id' => 'test2',
//                'content' => $this->renderPartial('_viewDetailMovementOut', array(
//                    'receiveParts' => $receiveParts,
//                    'receivePartsDetails' => $receivePartsDetails,
//                ), true)
//            ),
        ),

        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab',
    )); ?>
</div>