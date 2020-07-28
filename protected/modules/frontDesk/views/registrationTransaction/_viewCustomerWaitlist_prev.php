<?php
$nItemsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalcw = count($models);
$current_from_cw = ($page == 1) ? 1 : (($page * $nItemsPerPage) + 1) - 10;
$current_to_cw = (($page * $nItemsPerPage) >= $totalcw) ? $totalcw : ($page * $nItemsPerPage);
$pagination = round(count($models) / 10);
?>
<div class="wide form" style="border-bottom: 1px solid #CCC">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route."#timecounter"),
	'method'=>'get',
	// 'id'=>'isisis',
	'htmlOptions'=>array('id'=>'epoxyForm'),
)); ?>
<div class="row">
	<div class="small-12 medium-6 columns">
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix" >Customer</label>
			</div>
			<div class="small-8 columns">
				<input size="18" maxlength="18" value="<?= !empty($_GET['RegistrationTransaction']['customer_name'])?$_GET['RegistrationTransaction']['customer_name']:''?>" id="RegistrationTransaction_customer_name_epoxy" name="RegistrationTransaction[customer_name]" type="text" onclick="jQuery('#customer-dialog').dialog('open'); return false;">
				<input type="hidden" name="RegistrationTransaction[tab_type]" value="0" id="tab_type">
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Customer Type</label>
			</div>
			<div class="small-8 columns">
				<select name="RegistrationTransaction[customer_type]">
				<option value="">[--Select Customer Type--]</option>
				<option value="Individual" <?= empty($_GET['RegistrationTransaction']['customer_type'])?'':($_GET['RegistrationTransaction']['customer_type'] == 'Individual')?'selected':'';?>>Individual</option>
				<option value="Company" <?= empty($_GET['RegistrationTransaction']['customer_type'])?'':($_GET['RegistrationTransaction']['customer_type'] == 'Company')?'selected':'';?>>Company</option>
				</select>
			</div>
		</div>
	</div>	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Branch</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::dropDownList('RegistrationTransaction[branch_id]','',CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
	    						'prompt' => '[--Select Branch--]'
	    						)
	    					); 
	    					?>
			</div>
		</div>
	</div>	
	</div>
	<div class="small-12 medium-6 columns">
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Transaction Date</label>
			</div>
			<div class="small-8 columns">
				<!-- <input size="18" maxlength="18" value="<?= !empty($_GET['RegistrationTransaction']['date_repair'])?$_GET['RegistrationTransaction']['date_repair']:''; ?>" name="RegistrationTransaction[date_repair]" type="text"> -->

				<?php /*
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				    'name'=>'RegistrationTransaction[date_repair]',
				    // additional javascript options for the date picker plugin
				    'options'=>array(
				        'showAnim'=>'fold',
                        'dateFormat' => 'yy-mm-dd',
				    ),
				    'htmlOptions'=>array(
				    	'value' =>!empty($_GET['RegistrationTransaction']['date_repair'])?$_GET['RegistrationTransaction']['date_repair']:'',
				        // 'style'=>'height:20px;'
				    ),
				));*/?>

					<div class="row">
						<div class="medium-6 columns">
							<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							    'name'=>'RegistrationTransaction[transaction_date_from]',
							    // additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'fold',
			                        'dateFormat' => 'yy-mm-dd',
							    ),
							    'htmlOptions'=>array(
							    	'id'=>'epoxy_transaction_date_0',
							    	'value' =>!empty($_GET['RegistrationTransaction']['transaction_date_from'])?$_GET['RegistrationTransaction']['transaction_date_from']:'',
							        // 'style'=>'height:20px;'
							    ),
							));?>
						</div>
						<div class="medium-6 columns">

							<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							    'name'=>'RegistrationTransaction[transaction_date_to]',
							    // additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'fold',
							        'dateFormat' => 'yy-mm-dd',
							    ),
							    'htmlOptions'=>array(
							    	'id'=>'epoxy_transaction_date_1',
							    	'value' =>!empty($_GET['RegistrationTransaction']['transaction_date_to'])?$_GET['RegistrationTransaction']['transaction_date_to']:'',
							        // 'style'=>'height:20px;'
							    ),
							));?>
						</div>
					</div>

			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Repair Type</label>
			</div>
			<div class="small-8 columns">
				<select name="RegistrationTransaction[repair_type]" >
				<option value="">[--Select Repair Type--]</option>
				<option value="GR"  <?= empty($_GET['RegistrationTransaction']['repair_type'])?'':($_GET['RegistrationTransaction']['repair_type'] == 'GR')?'selected':'';?>>General Repair</option>
				<option value="BR"  <?= empty($_GET['RegistrationTransaction']['repair_type'])?'':($_GET['RegistrationTransaction']['repair_type'] == 'BR')?'selected':'';?>>Body Repair</option>
				</select>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Status</label>
			</div>
			<div class="small-8 columns">
				<?php 
					echo CHtml::dropDownList('RegistrationTransaction[status]', '', 
						array(
							''=>'All',
							'Registration'=>'Registration',
							'Pending'=>'Pending',
							'Available'=>'Available',
							'On Progress'=>'On Progress',
							'Finished'=>'Finished'
						), 
						array("style"=>"margin-bottom:0px;")
					);
				?>
			</div>
		</div>
	</div>	

	<div class="buttons text-right">
		<?php echo CHtml::submitButton('Search', 
			array( 
				'class'=>'button cbutton', 
				'id'=>'epoxyBtn',
				'onclick'=>'$("#epoxyDatas-transaction-grid").yiiGridView("update", {
						data: $("#epoxyForm").serialize()
					});
					return false;'
				)
		); ?>
	</div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->

<div class="row">
    <div class="large-12 columns">
        <h1>Customer Waitlist</h1>
        <div class="waitlist grid-view">
            <table id="waitlisttable" class="sss">
                <thead>
                <tr>
                    <th>Plate#</th>
                    <th>Customer</th>
                    <th>Car Make</th>
                    <th>Car Model</th>
<!--                    <th>Car Year</th>-->
                    <th>WO #</th>
                    <th>Position</th>
                    <th>Duration</th>
                    <th>Insurance</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($models, $nItemsPerPage * ($page - 1), $nItemsPerPage) as $i => $model): ?>
                    <tr>
                        <td><?php echo $model->vehicle != null ? $model->vehicle->plate_number : ' '; ?></td>
                        <td><?php echo $model->customer_id != null ? $model->customer->name : ' '; ?></td>
                        <td><?php echo $model->vehicle->carMake != null ? $model->vehicle->carMake->name : ' '; ?></td>
                        <td><?php echo $model->vehicle->carModel != null ? $model->vehicle->carModel->name : ' '; ?></td>
<!--                        <td><?php //echo $model->vehicle != null ? $model->vehicle->year : ' '; ?></td>-->
                        <td><?php echo $model->work_order_number != null ? $model->work_order_number : ' '; ?></td>
                        <td><?php echo $model->status != null ? $model->status : '-'; ?></td>
                        <?php if ($model->repair_type == 'GR') {
                            $regServices = RegistrationService::model()->findAllByAttributes(array(
                                'registration_transaction_id' => $model->id,
                                'is_body_repair' => 0
                            ));
                        } else {
                            $regServices = RegistrationService::model()->findAllByAttributes(array(
                                'registration_transaction_id' => $model->id,
                                'is_body_repair' => 1
                            ));
                        }
                        $duration = 0;
                        foreach ($regServices as $key => $regService) {
                            $duration += $regService->service->flat_rate_hour;
                        }
                        ?>
                        <td><?php echo $duration; ?></td>
                        <td><?php echo $model->insuranceCompany != null ? $model->insuranceCompany->name : '-'; ?></td>
                        <td>
                            <?php echo CHtml::tag('button', array(
                                    // 'name'=>'btnSubmit',
                                'disabled' => count($regServices) == 0 ? true : false,
                                'type' => 'button',
                                'class' => 'hello button expand',
                                'onclick' => '$("#detail-' . $i . '").toggle();'
                            ), '<span class="fa fa-caret-down"></span> Detail'); ?>
                        </td>
                    </tr>
                    <tr id="detail-<?php echo $i ?>" class="hide">
                        <td colspan="9">
                            <table>
                                <thead>
                                <tr>
                                    <th width="400px">Service</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Duration</th>
                                    <th>Customer Name</th>
                                    <th>Customer Type</th>
                                    <th>Working By</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($regServices as $key => $regService) : ?>
                                    <tr>
                                        <td><?php echo $regService->service->name; ?></td>
                                        <td><?php echo $regService->start; ?></td>
                                        <td><?php echo $regService->end; ?></td>
                                        <td><?php echo $regService->service->flat_rate_hour; ?></td>
                                        <td><?php echo $regService->registrationTransaction->customer->name; ?></td>
                                        <td><?php echo $regService->registrationTransaction->customer->customer_type; ?></td>
                                        <td>
                                            <?php $first = true;
                                            $rec = "";
                                            $eDetails = RegistrationServiceEmployee::model()->findAllByAttributes(array('registration_service_id' => $regService->id));
                                            foreach ($eDetails as $eDetail) {
                                                $employee = Employee::model()->findByPk($eDetail->employee_id);
                                                if ($first === true) {
                                                    $first = false;
                                                } else {
                                                    $rec .= ', ';
                                                }
                                                $rec .= $employee->name;

                                            }
                                            echo $rec; ?>
                                        </td>
                                        <td><?php echo $regService->status; ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));

                            if ($products != null) { ?>
                                <table>
                                    <tr>
                                        <th width="400px">Product</th>
                                        <th>Product Status</th>
                                        <th>Qty Movement</th>
                                        <th>Qty Movement Left</th>
                                    </tr>
                                    <?php foreach ($products as $key => $product) { ?>
                                        <tr>
                                            <td><?= $product->product->name ?></td>
                                            <td></td>
                                            <td><?= $product->quantity_movement ?></td>
                                            <td><?= $product->quantity_movement_left ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <div class="clearfix">
                <div class="summary">
                    Displaying <?php echo $current_from_cw; ?>-<?php echo $current_to_cw; ?> of <?php echo $totalcw; ?> results.
                </div>
                <div class="pager">
                    <ul class="yiiPager">
                        <li class="first">
                            <?php echo CHtml::link('&lt;&lt; First', array('registrationTransaction/customerWaitlist?page=1')); ?>
                        </li>
                        <li class="previous">
                            <?php echo CHtml::link('&lt; Previous', array('registrationTransaction/customerWaitlist?page=' . ($page - 1))); ?>
                        </li>
                        <?php for ($i = 1; $i <= $pagination; $i++) {
                            $selected = ($i == $page) ? "selected" : "";
                            echo "<li class=\"page " . $selected . "\">";
                            echo CHtml::link($i, array('registrationTransaction/customerWaitlist?page=' . $i));
                            echo "</li>";
                        }
                        ?>
                        <li class="next">
                            <?php echo CHtml::link('Next &gt;', array('registrationTransaction/customerWaitlist?page=' . ($page + 1))); ?>
                        </li>
                        <li class="last"> 
                            <?php echo CHtml::link('Last &gt;&gt;', array('registrationTransaction/customerWaitlist?page=' . $pagination)); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>        