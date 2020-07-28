<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */

$this->breadcrumbs=array(
	'Jurnal Penyesuaians'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List JurnalPenyesuaian', 'url'=>array('index')),
	array('label'=>'Create JurnalPenyesuaian', 'url'=>array('create')),
	array('label'=>'Update JurnalPenyesuaian', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete JurnalPenyesuaian', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JurnalPenyesuaian', 'url'=>array('admin')),
);
?>

<!--<h1>View JurnalPenyesuaian #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Jurnal Penyesuaian', Yii::app()->baseUrl.'/accounting/jurnalPenyesuaian/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("accounting.jurnalPenyesuaian.admin"))) ?>
		<?php if ($model->status != "Approved" && $model->status != "Rejected"): ?>
			<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/accounting/jurnalPenyesuaian/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("accounting.cashTransaction.update"))) ?>
			<?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/accounting/jurnalPenyesuaian/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("accounting.cashTransaction.updateApproval"))) ?>
		<?php endif ?>
		
		<h1>View JurnalPenyesuaian #<?php echo $model->id; ?></h1>

		<?php //$this->widget('zii.widgets.CDetailView', array(
			// 'data'=>$model,
			// 'attributes'=>array(
			// 	'id',
			// 	'transaction_number',
			// 	'transaction_date',
			// 	'coa_biaya_id',
			// 	'coa_akumulasi_id',
			// 	'amount',
			// 	'branch_id',
			// 	'user_id',
			// ),
		//)); ?>
	</div>
		<div class="row">
			<div class="large-12 columns">
				<div class="row">

					<div class="large-6 columns">
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Transaction Number</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->transaction_number; ?>"> 
								</div>
							</div>
						</div>
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Transaction Date</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->transaction_date; ?>"> 
								</div>
							</div>
						</div>
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Status</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->status; ?>"> 
								</div>
							</div>
						</div>
					</div>
				
					<div class="large-6 columns">
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Branch</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->branch->name; ?>"> 
								</div>
							</div>
						</div>
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">User</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->user_id; ?>"> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="jurnal">
			<table>
				<tr>
					<th>COA BIAYA</th>
					<th>COA AKUMULASI</th>
					<th>DEBIT</th>
					<th>KREDIT</th>
				</tr>
				<tr>
					<td><?php echo $model->coaBiaya->name ?></td>
					<td>&nbsp;</td>
					<td><?php echo $model->amount; ?></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $model->coaAkumulasi->name ?></td>
					<td>&nbsp;</td>
					<td><?php echo $model->amount; ?></td>
				</tr>
			</table>
		</div>
	
</div>