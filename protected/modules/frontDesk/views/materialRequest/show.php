<?php
/* @var $this MaterialRequestController */
/* @var $materialRequest MaterialRequest */

$this->breadcrumbs = array(
    'Material Requests' => array('admin'),
    $materialRequest->id,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">        
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
	

