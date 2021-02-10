<table class="items" id="divisions_details">
	<thead>
		<tr>
			<th>Division</th>
			<th>Position</th>
			<th>Level</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>


		<?php foreach ($employee->divisionDetails as $i => $divisionDetail): ?>
			<tr>
				
				<?php 
				$divBranches = DivisionBranch::model()->findAllByAttributes(array('branch_id'=>$employee->header->branch_id == NULL ? $_POST['Employee']['branch_id'] : $employee->header->branch_id));
				$divisionId= array();
				foreach ($divBranches as $key => $divBranch) {
					$divisionId[] = $divBranch->division_id;
				}
				$divisioncriteria = new CDbCriteria();
				$divisioncriteria->addIncondition('id',$divisionId);

				?>

				<td>
					<?php 
					echo CHtml::activeDropDownList($divisionDetail,"[$i]division_id", CHtml::listData(Division::model()->findAll($divisioncriteria), 'id', 'name'),array(
						'prompt'=>'[--Select Division--]',
						'onchange'=> 'jQuery.ajax({
							type: "POST",
				                  //dataType: "JSON",
							url: "' . CController::createUrl('ajaxGetPosition',array()) . '/divisionId/" + jQuery(this).val(),
							data: jQuery("form").serialize(),
							success: function(data){
								console.log(data);
								jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_position_id").html(data);
								if(jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_division_id").val() == ""){
									jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_position_id").html("<option value=\"\">[--Select Position--]</option>");}
								}
							});')
					); 
					?>
				</td>	

				<?php $divPositions = DivisionPosition::model()->findAllByAttributes(array('division_id'=>$divisionDetail->division_id));
				$positionId= array();
				foreach ($divPositions as $key => $divPosition) {
					$positionId[] = $divPosition->position_id;
				}
				$positioncriteria = new CDbCriteria();
				$positioncriteria->addIncondition('id',$positionId);

				?>
				<td>
					<?php echo CHtml::activeDropDownList($divisionDetail,"[$i]position_id", CHtml::listData(Position::model()->findAll($positioncriteria), 'id', 'name'),array(
						'prompt'=>'[--Select Position--]',
						'onchange'=> 'jQuery.ajax({
							type: "POST",
				                  //dataType: "JSON",
							url: "' . CController::createUrl('ajaxGetLevel',array()) . '/positionId/" + jQuery(this).val(),
							data: jQuery("form").serialize(),
							success: function(data){
								console.log(data);
								jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_level_id").html(data);
								if(jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_position_id").val() == ""){
									jQuery("#EmployeeBranchDivisionPositionLevel_'.$i.'_level_id").html("<option value=\"\">[--Select Level--]</option>");}
								}
							});')); ?>
						</td>
						<td>
							<?php 
							$positionLevels = PositionLevel::model()->findAllByAttributes(array('position_id'=>$divisionDetail->position_id));
							$levelId = array();
							foreach($positionLevels as $positionLevel) {
								$levelId[] = $positionLevel->level_id;
							} 
							$levelcriteria = new CDbCriteria();
							$levelcriteria->addIncondition('id',$levelId);
							?>
							<?php echo CHtml::activeDropDownList($divisionDetail,"[$i]level_id",$divisionDetail->position_id != '' ? CHtml::listData(Level::model()->findAll($levelcriteria), 'id', 'name') : array(),array('prompt'=>'[--Select Level--]')); ?>


						</td>




						<td>
							<?php
							echo CHtml::button('X', array(
								'onclick' => CHtml::ajax(array(
									'type' => 'POST',
									'url' => CController::createUrl('ajaxHtmlRemoveDivisionDetail', array('id' => $employee->header->id, 'index' => $i)),
									'update' => '#branch',
									)),
								));
								?>
							</td>

						</tr>
					<?php endforeach ?>

				</tbody>
			</table>