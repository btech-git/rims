<?php
/* @var $this BranchController */
/* @var $model Branch */

$this->breadcrumbs=array(
	'Company',	
	'Branches'=>array('admin'),
	'View Branch '.$model->name,
);
// $this->menu=array(
// 	array('label'=>'List Branch', 'url'=>array('index')),
// 	array('label'=>'Create Branch', 'url'=>array('create')),
// 	array('label'=>'Update Branch', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Branch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Branch', 'url'=>array('admin')),
// );
?>
		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/master/branch/admin';?>"><span class="fa fa-th-list"></span>Manage Branch</a>
				<?php if (Yii::app()->user->checkAccess("master.branch.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<h1>Branch <?php echo $model->code ?></h1>
						<?php $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model,
							'attributes'=>array(
								//'id',
								array('name'=>'company', 'value'=>$model->company != "" ?$model->company->name : ''),
								'coa_prefix',
								'name',
								'code',								
								'address',
								array('name'=>'province_name', 'value'=>$model->province->name),
								array('name'=>'city_name', 'value'=>$model->city->name),
								array('name'=>'coa_interbranch_inventory_name', 'value'=>$model->coaInterbranchInventory != "" ? $model->coaInterbranchInventory->name : ''),
								array('name'=>'coa_interbranch_inventory_code', 'value'=>$model->coaInterbranchInventory != "" ? $model->coaInterbranchInventory->code : ''),
								
								//'city',
								'zipcode',
								// 'phone',
								// 'fax',	
								'email',
								'status',
							),
						)); ?>
		</div>
<div class="row">
	<div class="small-12 columns">
		<h3>Phones</h3>
		<table >
			
			<!-- <tr>
				<td>Name</td>
				
			</tr> -->
			<?php foreach ($branchPhones as $key => $branchPhone): ?>
				<tr>
						
					<td><?php echo $branchPhone->phone_no; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	</div>
	<div class="row">
	<div class="small-12 columns">
		<h3>Fax</h3>
		<table >
			
			<!-- <tr>
				<td>Name</td>
				
			</tr> -->
			<?php foreach ($branchFaxes as $key => $branchFax): ?>
				<tr>
						
					<td><?php echo $branchFax->fax_no; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	</div>
<div class="row">
	<div class="small-12 columns">
		<h3>Warehouses</h3>
		<table >
			<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<!-- <tr>
				<td>Name</td>
				
			</tr> -->
			<?php foreach ($branchWarehouses as $key => $branchWarehouse): ?>
				<tr>
						<?php //$warehouse = Warehouse::model()->findByPK($branchWarehouse->warehouse_id); ?>
					<td><?php echo $branchWarehouse->name; ?></td>	
					<td><?php echo $branchWarehouse->description; ?></td>
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>
	<div class="row">
	<div class="small-12 columns">
		<h3>Division - Position - Level - Employee</h3>
		<table >
			<thead>
				<tr>
						<td>Division</td>
						<td>Details</td>
				</tr>
			</thead>
			<?php foreach ($divisionBranches as $key => $divisionBranch): ?>
				<tr>
						<?php $division = Division::model()->findByPK($divisionBranch->division_id); ?>
						<td><?php echo $division->name; ?></td>
						<td>
							<table>
								<thead>
									<tr>
										<td>Position</td>
									</tr>
								</thead>
									<?php $divisionPositions = DivisionPosition::model()->findAllByAttributes(array('division_id'=>$division->id)); ?>
									<?php foreach ($divisionPositions as $key => $divisionPosition): ?>
										<tr>
											<?php $position = Position::model()->findByPK($divisionPosition->position_id); ?>
											<td><?php echo $position->name; ?></td>
											<td>
												<table>
													<thead>
														<tr>
															<td>Level</td>
															<td>Employees</td>
														</tr>
													</thead>
													<?php $positionLevels = PositionLevel::model()->findAllByAttributes(array('position_id'=>$position->id)); ?>
													<?php foreach ($positionLevels as $positionLevel): ?>
														<tr>
																<?php $level = Level::model()->findByPK($positionLevel->level_id); ?>
																<td><?php echo $level->name ?></td>
																<?php $branchEmployees = EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array('branch_id'=>$model->id,'division_id'=>$division->id,'position_id'=>$position->id,'level_id'=>$level->id)); 
																	$count = count($branchEmployees);
																?>
																<td><?php echo $count; ?></td>
														</tr>
													<?php endforeach ?>
													
												</table>
											</td>
										</tr>
									<?php endforeach ?>
									
							</table>
						</td>
				</tr>
			<?php endforeach ?>
		</table>
	</div></div>

	<div class="row">
		<div class="small-12 columns">
			<h3>Divisions</h3>
			<table >
				<thead>
					<tr>
							<td>Division Name</td>
							<td>Division Email</td>
							<td>Action</td>
					</tr>
				</thead>
			
				<?php foreach ($divisionBranches as $key => $divisionBranch): ?>
					
					<tr>
							<?php $division = Division::model()->findByPK($divisionBranch->division_id); ?>
						<td><?php echo $division->name; ?></td>	
						<td><?php echo $divisionBranch->email; ?></td>	
						<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updateDivision',array('branchId'=>$model->id,'divisionId'=>$divisionBranch->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
	
	<!-- To display list ofEquipments related to this Branch -->
	<div class="row">
		<div class="small-12 columns">
			<h3>Equipments</h3>
			<table >
				<thead>
					<tr>
						<td>Name</td>
						<td>Equipment Type</td>
						<td>Equipment Sub Type</td>
					</tr>
				</thead>
			
				<?php foreach ($equipments as $key => $equipment): ?>
					
					<tr>
						<td><?php echo $equipment->name; ?></td>	
						<td><?php echo $equipment->equipmentType->name; ?></td>	
						<td><?php echo $equipment->equipmentSubType->name; ?></td>	
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
	<!-- End of To display list ofEquipments related to this Branch -->
	
</div>


