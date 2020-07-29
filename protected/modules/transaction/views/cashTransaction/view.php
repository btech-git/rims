<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs=array(
	'Cash Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashTransaction', 'url'=>array('index')),
	array('label'=>'Create CashTransaction', 'url'=>array('create')),
	array('label'=>'Update CashTransaction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashTransaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashTransaction', 'url'=>array('admin')),
);
?>

<!--<h1>View CashTransaction #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>

		<?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Cash Transaction', Yii::app()->baseUrl.'/transaction/cashTransaction/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.cashTransaction.admin"))) ?>
		
		<?php if ($model->status != "Approved" && $model->status != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/cashTransaction/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.cashTransaction.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/cashTransaction/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.cashTransaction.updateApproval"))) ?>
		<?php endif ?>
		<h1>View Cash Transaction #<?php echo $model->id; ?></h1>

		 <?php //$this->widget('zii.widgets.CDetailView', array(
		// 	'data'=>$model,
		// 	'attributes'=>array(
		// 		'id',
		// 		'transaction_number',
		// 		'transaction_date',
		// 		'transaction_type',
		// 		'coa_id',
		// 		'debit_amount',
		// 		'credit_amount',
		// 		'branch_id',
		// 		'user_id',
		// 	),
		// )); ?>

		<div class="row">
		<div class="large-12 columns">
			
					<div class="row">
					<div class="large-6 columns">
						
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Transaction Type</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->transaction_type; ?>"> 
								</div>
							</div>
						</div>
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Transaction Name</span>
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
									<span class="prefix">Debit</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->debit_amount; ?>"> 
								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">Credit</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->credit_amount; ?>"> 
								</div>
							</div>
						</div>
						
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<span class="prefix">User</span>
								</div>
								<div class="small-8 columns">
									<input type="text" readonly="true" value="<?php echo $model->user->username; ?>"> 
								</div>
							</div>
						</div>
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
						
					</div>
				</div>
				
				<fieldset>
					<legend>COA Detail</legend>
					<div class="large-12 columns">
						<div class="row">
							<div class="large-6 columns">
								
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">COA Name</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->name; ?>"> 
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">COA Code</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->code; ?>"> 
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">COA Normal Balance</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->normal_balance; ?>"> 
										</div>
									</div>
								</div>
								

							</div>
					

							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Opening Balance</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->opening_balance; ?>"> 
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Closing Balance</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->closing_balance; ?>"> 
										</div>
									</div>
								</div>
								
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Debit</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->debit; ?>"> 
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Credit</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->coa->credit; ?>"> 
										</div>
									</div>
								</div>
								
							</div>
						</div>
				</fieldset>
				<fieldset>
					<legend>Details</legend>
					<table>
						<thead>
							<tr>
								<th>Coa</th>
								<th>Normal Balance</th>
								<th>Amount</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $key => $detail): ?>
								<tr>
									<td><?php echo $detail->coa != "" ? $detail->coa->name : '' ; ?></td>
									<td><?php echo $detail->coa != "" ? $detail->coa->normal_balance : '' ?></td>
									<td><?php echo Yii::app()->numberFormatter->format('#,##0.00', $detail->amount); ?></td>
									<td><?php echo $detail->notes; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</fieldset>
			<fieldset>
				<legend>Approval Status</legend>
				<table>
					<thead>
						<tr>
				 			<th>Approval type</th>
				 			<th>Revision</th>
				 			<th>date</th>
				 			<th>note</th>
				 			<th>supervisor</th>
				 		</tr>
					</thead>
					<tbody>
						<?php foreach ($revisionHistories as $key => $history): ?>
							<tr>
					 			<td><?php echo $history->approval_type; ?></td>
					 			<td><?php echo $history->revision; ?></td>
					 			<td><?php echo $history->date; ?></td>
					 			<td><?php echo $history->note; ?></td>
					 			<td><?php echo $history->supervisor->username; ?></td>
					 		</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</fieldset>
			<fieldset>
				<legend>Attached Images</legend>

				<?php foreach ($postImages as $postImage):
					$dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $model->id . '/' . $postImage->filename;
					$src = Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $model->id . '/' . $postImage->filename;
				?>
					<div class="row">
						<div class="small-3 columns">
							<div style="margin-bottom:.5rem">
								<?php echo CHtml::image($src, $model->transaction_type . "Image"); ?>
							</div>
						</div>
						<div class="small-8 columns">
							<div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
								<?php echo (Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $model->id . '/' . $postImage->filename); ?>
							</div>
						</div>
						
					</div>
				<?php endforeach; ?>
			</fieldset>
			
	</div>
</div>
