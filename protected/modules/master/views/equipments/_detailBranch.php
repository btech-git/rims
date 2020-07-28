<table class="items saved_branch">
			<thead>
			<tr>
				<th>Branch</th>
				<th>Brand</th>
				<th>Purchase Date</th>
				<th>Age</th>
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($equipment->branchDetails as $i => $branchDetail): ?>
					<tr class="added" >
						<td><?php echo CHtml::activeHiddenField($branchDetail,"[$i]branch_id"); ?>
						<?php $branch = Branch::model()->findByPK($branchDetail->branch_id); ?>
						<?php echo CHtml::activeTextField($branchDetail,"[$i]branch_name",array('value'=>$branchDetail->branch_id!= '' ? $branch->name : '','readonly'=>true )); ?></td>
						<!--<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveBranchDetail', array('id' => $equipment->header->id, 'index' => $i,'branch_name'=>$branch->name)),
							       	'update' => '#branch',
								)),
					     	));
				     	?>
						</td>-->
						<!--<td><?php //echo CHtml::activeTextField($branchDetail,"[$i]purchase_date",array('value'=>$branchDetail->purchase_date!= '' ? $branchDetail->purchase_date : '')); ?></td>-->
								<td><?php echo CHtml::activeTextField($branchDetail,"[$i]brand",array('value'=>$branchDetail->brand!= '' ? $branchDetail->brand : '','class'=>'in','placeholder'=>'Brand')); ?></td>
				
						<td>
							<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $branchDetail,
											 'attribute' => "[$i]purchase_date",
											 // additional javascript options for the date picker plugin
											 'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
												 'changeYear'=>true,
												 'yearRange'=>'1900:2020',												
											),
											'htmlOptions'=>array(
													'onchange'=>  'jQuery.ajax({
																type: "POST",
																//dataType: "JSON",
																url: "' . CController::createUrl('ajaxGetAge').'/purchase_date/"+$(this).val() ,
																data: jQuery("form").serialize(),
																success: function(data){
																	jQuery("#EquipmentBranch_'.$i.'_age").val(data);
																	},
															});',
											'placeholder' => 'Purchase Date',
													),
										 )); ?>
						</td>
						<td><?php echo CHtml::activeTextField($branchDetail,"[$i]age",array('value'=>$branchDetail->age!= '' ? $branchDetail->age : '','class'=>'in','placeholder'=>'Age')); ?></td>
					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>