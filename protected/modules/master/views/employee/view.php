<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Company',
	'Employees'=>array('admin'),
	'View Employee '.$model->name,
);

$this->menu=array(
	array('label'=>'List Employee', 'url'=>array('index')),
	array('label'=>'Create Employee', 'url'=>array('create')),
	array('label'=>'Update Employee', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Employee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Employee', 'url'=>array('admin')),
);
?>
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/employee/admin';?>"><span class="fa fa-list"></span>Manage Employees</a>
				<?php if (Yii::app()->user->checkAccess("master.employee.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
		<h1>View Employee <?php echo $model->name; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				//'employee_id',
				'name',
				'local_address',
				array('name'=>'province_name','value'=>$model->province->name),
				array('name'=>'city_name','value'=>$model->city->name),
				'home_address',
				array('name'=>'home_province_name','value'=>$model->homeProvince->name),
				array('name'=>'home_city_name','value'=>$model->homeProvince->name),
				'sex',
				// 'phone',
				// 'mobile_phone',
				'email',
				'id_card',
				'driving_license',
				'status',
				'salary_type',
				'basic_salary',
				'payment_type',
				'code',
			),
		)); ?>
		</div>
	</div>

	
<div class="row">
	<div class="small-12 columns">
		<h3>Employee Bank Accounts</h3>
		<table>
			<thead>
				<tr>
					<td>Bank Name</td>
					<td>Account Name</td>
					<td>Account No</td>
					<td>Action</td>
				</tr>
			</thead>
			<?php foreach ($employeeBanks as $key => $employeeBank): ?>
				<tr>
					<?php $bank = Bank::model()->findByPk($employeeBank->bank_id); ?>
					<td><?php echo $bank->name; ?></td>
					<td><?php echo $employeeBank->account_name; ?></td>	
					<td><?php echo $employeeBank->account_no; ?></td>	
					<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updateBank',array('empId'=>$model->id,'bankId'=>$employeeBank->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
					
				</tr>
			<?php endforeach ?>
		</table>
		</div>
	</div>

	<div class="row">
	<div class="small-12 columns">
		<h3>Employee Incentives</h3>
		<table >
			<thead>
				<tr>

					<td>Name</td>
					<td>Amount</td>
					<td>Action</td>
				</tr>
			</thead>
			<?php foreach ($employeeIncentives as $key => $employeeIncentive): ?>
				<tr>
					<?php //$incentive = Incentive::model()->findByPk($employeeIncentive->incentive_id); ?>
					<td><?php echo $employeeIncentive->incentive->name; ?></td>	
					<td><?php echo $employeeIncentive->amount; ?></td>	
						<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updateIncentive',array('empId'=>$model->id,'incentiveId'=>$employeeIncentive->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
				</tr>
			<?php endforeach ?>
		</table>
		</div>
	</div>

	<div class="row">
	<div class="small-12 columns">

		<h3>Employee Deductions</h3>
		<table >
			<thead>
				<tr>
					<td>Name</td>
					<td>Amount</td>
					<td>Action</td>
				</tr>
			</thead>
			<?php foreach ($employeeDeductions as $key => $employeeDeduction): ?>
				<tr>
					<?php //$incentive = Incentive::model()->findByPk($employeeIncentive->incentive_id); ?>
					<td><?php echo $employeeDeduction->deduction->name; ?></td>	
					<td><?php echo $employeeDeduction->amount; ?></td>	
					<td><a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/updateDeduction',array('empId'=>$model->id,'deductionId'=>$employeeDeduction->id));?>"><span class="fa fa-pencil"></span>edit</a></td>
				</tr>
			<?php endforeach ?>
		</table>
		</div>
	</div>

	<div class="row">
	<div class="small-12 columns">
		<h3>Branch - Division - Position - Level</h3>
		<table >
			<thead>
				<tr>
					<td>Branch</td>
					<td>Division</td>
					<td>Position</td>
					<td>Level</td>
				</tr>
			</thead>
			<?php foreach ($employeeDivisions as $key => $employeeDivision): ?>
				<tr>
					<?php $branch = Branch::model()->findByPk($employeeDivision->branch_id); ?>
					<?php $division = Division::model()->findByPk($employeeDivision->division_id); ?>
					<?php $position = Position::model()->findByPk($employeeDivision->position_id); ?>
					<?php $level = Level::model()->findByPk($employeeDivision->level->id); ?>
					<td><?php echo $branch->name ?></td>
					<td><?php echo $division->name ?></td>
					<td><?php echo $position->name ?></td>
					<td><?php echo $level->name ?></td>
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	</div>
	<div class="row">
	<div class="small-12 columns">
	<div class="grid-view">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'attendance-grid',
			'dataProvider'=>$dataProvider,
			'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
			'pager'=>array(
			   'cssFile'=>false,
			   'header'=>'',
			),

			// 'filter'=>$model,
			'columns'=>array(
				// 'id',
				'date',
				'login_time',
				'logout_time',
				'total_hour',

				// 'total_stock',
				[
					'header'=>'notes',
					'name'=>'notes',
					'value'=>'CHtml::dropDownList("EmployeeAttendance[notes]", "$data->notes", 
								array(
									""=>"No overtime",
									"Overtime" => "Overtime",
									"Izin" => "Izin",
									"Alpha" => "Alpha",
									
								)
							)',
					'type'=>'raw'
				],
				
				[
			        'value'=>'CHtml::button("SAVE",array("id"=>"btnsave","rel"=>"$data->id", "class"=>"button cbutton secondary", "style"=>"background-color:#767171; color:#fff;"))',
			        'type'=>"raw"
				],
				// 'manufacturer_code',
				// 'warehouse_id',
				// 'minimal_stock',
				// 'status',
				/*array(
					'class'=>'CButtonColumn',
					'template'=>'{save}',
					'buttons'=>array
					(
						'save' => array
						(
							'label'=>'Save',
							// 'url'=>'Yii::app()->createUrl("master/forecastingProduct/calculate", array("id"=>$data->id))',
							'visible'=>'(Yii::app()->user->checkAccess("master.forecastingProduct.admin"))',
							'click'=>'js:function(){
							}',
							'options'=>[
								'rel'=>'".$data->id."',
							]
						),
					),
				),*/
			),
		)); ?>
		</div>
		</div>
		</div>

<?php 
Yii::app()->clientScript->registerScript('myforecastingProduct', '
		$("body").on("click","#btnsave",function(){
			var id = $(this).attr("rel");
			var data={};
			
			var sibs=$(this).parent().siblings();
			data.model_id=id;
			data.notes=$(sibs[4]).children().val();
			
			//alert(data.notes);
		
				$.ajax({
				    "url":"'.CHtml::normalizeUrl(array("employeeAttendance/saveData")).'",
				    "data":data,
				    "type":"POST",
				    "success":function(data){
				    	console.log(data);
				    	$("#attendance-grid").yiiGridView("update",{});
				    },
				})
			
			return false;
		});
    ', CClientScript::POS_END);
?>
