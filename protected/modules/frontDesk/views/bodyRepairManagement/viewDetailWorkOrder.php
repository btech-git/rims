<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Idle Management' => array('indexMechanic'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List RegistrationTransaction', 'url' => array('admin')),
    array('label' => 'Create RegistrationTransaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#registration-service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

	/*$('#registration-service-grid a.registration-service-start').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});

	$('#registration-service-grid a.registration-service-finish').live('click',function() {
        //if(!confirm('Are you sure you want to mark this commission as PAID?')) return false;
        
        var url = $(this).attr('href');
        //  do your post request here
        console.log(url);
        $.post(url,function(html){
            $.fn.yiiGridView.update('registration-service-grid');
        });
        return false;
	});*/
");
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Manage Body Repair Progress</h1>
        <div>
            <span style="text-align: center"><h3>Work Order Information</h3></span>
            
            <?php
            $duration = 0;
            $damage = "";
            $registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id, 'is_body_repair' => 1));
            foreach ($registrationServiceBodyRepairs as $rs) {
                $duration += $rs->hour;
            }
            $registrationDamages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
            foreach ($registrationDamages as $key => $registrationDamage) {
                $damage .= $registrationDamage->service->name;
                $damage .= ",";
            }
            ?>
            <?php $vehicle = $registration->vehicle; ?>
            <table>
                <tr>
                    <td>Plate Number: <?php echo $registration->vehicle->plate_number; ?></td>
                    <td>Problem : <?php echo $registration->problem; ?></td>
                </tr>
                <tr>
                    <td>Car Make: <?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td>Total Duration: <?php echo $duration . ' hr'; ?></td>
                </tr>
                <tr>
                    <td>Car Model: <?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td>Last Update By: <?php echo $registration->user->username; ?></td>
                </tr>
                <tr>
                    <td>Work Order #: <?php echo $registration->work_order_number; ?></td>
                    <td>Status: <?php echo $registration->status; ?></td>
                </tr>
                <tr>
                    <?php echo CHtml::beginForm(); ?>
                    <td>
                        Tambah Memo: 
                        <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
                        <?php echo CHtml::submitButton('Submit', array('name' => 'SubmitMemo', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
                    </td>
                    <?php echo CHtml::endForm(); ?>
                    <td>
                        List Memo
                        <table>
                            <?php foreach ($registration->registrationMemos as $i => $detail): ?>
                                <tr>
                                    <td style="width: 5%"><?php echo CHtml::encode($i + 1); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        
        <div>
            <span style="text-align: center"><h3>Products</h3></span>
            <table>
                <thead>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Qty Movement</th>
                    <th>Qty Movement Left</th>
                    <th>Qty Receive</th>
                    <th>Qty Receive Left</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php foreach ($registration->registrationProducts as $key => $rp): ?>
                        <tr>
                            <td><?php echo $rp->product->name; ?></td>
                            <td><?php echo $rp->quantity; ?></td>
                            <td><?php echo $rp->quantity_movement; ?></td>
                            <td><?php echo $rp->quantity_movement_left; ?></td>
                            <td><?php echo $rp->quantity_receive; ?></td>
                            <td><?php echo $rp->quantity_receive_left; ?></td>
                            <td>
                                <?php echo CHtml::tag('button', array(
                                    'type' => 'button',
                                    'class' => 'hello button expand',
                                    'onclick' => '$("#detail-' . $key . '").toggle();'
                                ), '<span class="fa fa-caret-down"></span> Detail'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td id="detail-<?php echo $key ?>" class="hide" colspan=6>
                                <?php
                                $mcriteria = new CDbCriteria;
                                $mcriteria->together = 'true';
                                $mcriteria->with = array('movementOutHeader');
                                $mcriteria->condition = "movementOutHeader.status ='Delivered' AND registration_product_id = " . $rp->id;
                                $getMovementDetails = MovementOutDetail::model()->findAll($mcriteria);
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Movement #</th>
                                            <th>Quantity Movement</th>
                                            <th>Quantity Received</th>
                                            <th>Quantity Received Left</th>
                                            <th>Quantity Receive</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <?php foreach ($getMovementDetails as $i => $md): ?>
                                        <tr>
                                            <td>
                                                <?php echo $md->movementOutHeader->movement_out_no; ?>
                                                <input type="hidden" id="movementOut-<?php echo $i ?>" value="<?php echo $md->movement_out_header_id; ?>">
                                                <input type="hidden" id="movementOutDetail-<?php echo $i ?>" value="<?php echo $md->id; ?>">
                                            </td>
                                            <td><input type="text" id="quantityMovement-<?php echo $i ?>" value="<?php echo $md->quantity ?>" readonly="true"></td>
                                            <td><input type="text" id="quantityReceived-<?php echo $i ?>" value="<?php echo $md->quantity_receive ?>" readonly="true"></td>
                                            <td><input type="text" id="quantityReceivedLeft-<?php echo $i ?>" value="<?php echo $md->quantity_receive_left ?>" readonly="true"></td>
                                            <td>
                                                <?php if ($md->quantity_receive_left > 0 || $md->quantity_receive_left == ""): ?>
                                                    <input type="text" id="quantity-<?php echo $i ?>" onchange ="
                                                        var move = +$('#quantityMovement-<?php echo $i ?>').val();
                                                        var quantity = +$('#quantity-<?php echo $i ?>').val();
                                                        if (quantity > move) {
                                                            alert('Quantity Receive could not be greater than Quantity Movement');
                                                            $('#quantity-<?php echo $i ?>').val(' ');
                                                        }
                                                        ;
                                                   ">
                                                <?php else: ?>
                                                    <input type="text" id="quantity-<?php echo $i ?>" readonly="true">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo CHtml::button('Receive', array(
                                                    'id' => 'detail-button',
                                                    'name' => 'Detail',
                                                    'class' => 'button cbutton left',
                                                    'disabled' => $md->quantity_receive_left > 0 || $md->quantity_receive_left == "" ? false : true,
                                                    'onclick' => ' 
                                                        $.ajax({
                                                        type: "POST",
                                                        //dataType: "JSON",
                                                        url: "' . CController::createUrl('receive', array('movementOutDetailId' => $md->id, 'registrationProductId' => $rp->id, 'quantity' => '')) . '"+$("#quantity-' . $i . '").val(),
                                                        data: $("form").serialize(),
                                                        success: function(html) {
                                                            alert("Success");
                                                            location.reload();
                                                        },})
                                                    '
                                                )); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div>
            <span style="text-align: center"><h3>Service</h3></span>
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'registration-service-grid',
                    'dataProvider' => $registrationServiceDataProvider,
                    'filter' => null, //$registrationService,
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'header' => "No",
                            'value' => '$this->grid->dataProvider->pagination->offset + $row+1',
                        ),
                        array('name' => 'service_id', 'value' => '$data->service->name'),
                        array('header' => 'Category', 'value' => '$data->service->serviceCategory->name'),
                        array('header' => 'Type', 'value' => '$data->service->serviceType->name'),
                    ),
                )); ?>
            </div>
        </div>
        
        <div>
            <span style="text-align: center"><h3>Damage</h3></span>
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'registration-damage-grid',
                    'dataProvider' => $registrationDamageDataProvider,
                    'filter' => null, //$registrationService,
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'header' => "No",
                            'value' => '$this->grid->dataProvider->pagination->offset + $row+1',
                        ),
                        array('name' => 'service_id', 'value' => '$data->service->name'),
                        'panel',
                        'damage_type',
                        'description',
                        'hour',
                        'waiting_time',
                    ),
                )); ?>
            </div>
        </div>
        
        <div>
            <span style="text-align: center"><h3>Service History</h3></span>
            <table>
                <thead>
                    <th>WO #</th>
                    <th>WO Date</th>
                    <th>Invoice #</th>
                    <th>Quick Service</th>
                    <th>Repair Type</th>
                    <th>Total Price</th>
                    <th>detail</th>
                </thead>

                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach (array_reverse($registrationHistories) as $i => $registrationHistory): ?>
                        <?php if ($counter < 11 && $registrationHistory->id !== $registration->id): ?>
                            <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationHistory->id)); ?>
                            <tr>
                                <td><?php echo $registrationHistory->work_order_number; ?></td>
                                <td><?php echo $registrationHistory->work_order_date; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
                                <td><?php echo $registrationHistory->is_quick_service == 1 ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $registrationHistory->repair_type; ?></td>
                                <td style="text-align: right"><?php echo number_format($registrationHistory->grand_total,0); ?></td>
                                <td>
                                    <?php echo CHtml::tag('button', array(
                                        'type'=>'button',
                                        'class' => 'hello button expand',
                                        'onclick'=>'$("#detail-'.$i.'").toggle();'
                                    ), '<span class="fa fa-caret-down"></span> Detail');?>
                                </td>
                            </tr>
                        
                            <tr>
                                <td id="detail-<?php echo $i?>" class="hide" colspan=6>
                                    <table>
                                        <tr>
                                            <td>Problem</td>
                                            <td><?php echo $registrationHistory->problem; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Services</td>
                                            <td>
                                                <?php  $first = true;
                                                $rec = "";
                                                $sDetails = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationHistory->id));

                                                foreach($sDetails as $sDetail) {
                                                    $service = Service::model()->findByPk($sDetail->service_id);
                                                    if ($first === true) {
                                                        $first = false;
                                                    }
                                                    else {
                                                        $rec .= ', ';
                                                    }
                                                    $rec .= $service->name;
                                                }

                                                echo $rec; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Products</td>
                                            <td>
                                                <?php  $first = true;
                                                $rec = "";
                                                $pDetails = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id'=>$registrationHistory->id));

                                                foreach($pDetails as $pDetail) {
                                                    $product = Product::model()->findByPk($pDetail->product_id);
                                                    if($first === true) {
                                                        $first = false;
                                                    }
                                                    else {
                                                        $rec .= ', ';
                                                    }
                                                    $rec .= $product->name;
                                                }

                                                echo $rec; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

                    <div>
                        <?php /* $this->widget('zii.widgets.jui.CJuiTabs', array(
                          'tabs' => array(
                          'Work Order' => array(
                          'content' => $this->renderPartial(
                          '_viewWorkOrderMechanic',
                          array(
                          'registration' => $registration,
                          'memo' => $memo,
                          ), true
                          ),
                          ),
                          'Products' => array(
                          'content' => $this->renderPartial(
                          '_viewProduct',
                          array(
                          'registration' => $registration,
                          ), true
                          ),
                          ),
                          'Services' => array(
                          'content' => $this->renderPartial(
                          '_viewService',
                          array(
                          'registration' => $registration,
                          'registrationService' => $registrationService,
                          'registrationServiceDataProvider' => $registrationServiceDataProvider,
                          ), true
                          ),
                          ),
                          'Damages' => array(
                          'content' => $this->renderPartial(
                          '_viewDamage',
                          array(
                          'registration' => $registration,
                          'registrationDamage' => $registrationDamage,
                          'registrationDamageDataProvider' => $registrationDamageDataProvider,
                          ), true
                          ),
                          ),
                          'Service History' => array(
                          'content' => $this->renderPartial(
                          '_viewServiceHistory',
                          array(
                          'registration' => $registration,
                          'vehicle' => $vehicle,
                          ), true
                          ),
                          ),
                          ),
                          // additional javascript options for the tabs plugin
                          'options' => array(
                          'collapsible' => true,
                          ),
                          // set id for this widgets
                          'id' => 'view_tab',
                          )); */ ?>
                    </div>

        <br />

        <div>
            <table>
                <caption>Body Repair</caption>
                <thead>
                    <tr style="background-color: lightblue">
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Process</th>
                        <th style="text-align: center">Start</th>
                        <th style="text-align: center">Finish</th>
                        <th style="text-align: center">Total Time</th>
                        <th style="text-align: center">Mechanic</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach ($registrationBodyRepairDetails as $i => $registrationBodyRepairDetail): ?>
                        <?php $isDetailRunning = $bodyRepairManagement->runningDetail === null ? false : $registrationBodyRepairDetail->id === $bodyRepairManagement->runningDetail->id; ?>
                        <tr style="<?php echo $isDetailRunning ? 'font-weight: bold; background-color: greenyellow' : ''; ?>">
                            <td style="text-align: center"><?php echo $i + 1; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'service_name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'start_date_time')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'finish_date_time')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'totalTimeFormatted')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetail, 'mechanic.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if ($bodyRepairManagement->runningDetail !== null): ?>
                <table>
                    <caption>Timesheet</caption>
                    <thead>
                        <tr style="background-color: orange">
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center">Start</th>
                            <th style="text-align: center">Finish</th>
                            <th style="text-align: center">Total</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($bodyRepairManagement->runningDetail->registrationBodyRepairDetailTimesheets as $i => $registrationBodyRepairDetailTimesheet): ?>
                            <tr>
                                <td style="text-align: center"><?php echo $i + 1; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'start_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'finish_date_time')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationBodyRepairDetailTimesheet, 'totalTimeFormatted')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($bodyRepairManagement->runningDetail !== null): ?>
    <?php $mechanicId = $bodyRepairManagement->runningDetail->mechanic_id; ?>

    <?php if ($mechanicId === null || $mechanicId !== null && $mechanicId === Yii::app()->user->id): ?>
        <div style="text-align: center">
            <?php if ($bodyRepairManagement->runningDetailTimesheet->start_date_time === null): ?>
                <?php echo CHtml::submitButton('Start', array('name' => 'StartOrPauseTimesheet', 'confirm' => 'Are you sure you want to start?', 'class' => 'btn_blue')); ?>
            <?php else: ?>
                <?php echo CHtml::submitButton('Pause', array('name' => 'StartOrPauseTimesheet', 'confirm' => 'Are you sure you want to pause?', 'class' => 'btn_blue')); ?>
                <?php echo CHtml::submitButton('Finish', array('name' => 'FinishTimesheet', 'confirm' => 'Are you sure you want to finish?', 'class' => 'btn_blue')); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php echo CHtml::endForm(); ?>  