<?php $ccontroller = Yii::app()->controller->id; ?>
<?php $ccaction = Yii::app()->controller->action->id; ?>
<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/'.$ccontroller.'/admin'); ?>"><span class="fa fa-th-list"></span>Manage Registration Transaction</a>
<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/'.$ccontroller.'/view',array('id'=>$head->id)); ?>">Back</a>
<table class="detail">
	<thead>
		<tr>
			<th>Realization Process</th>
			<th>Checked</th>
			<th>Checked Date</th>
			<th>Checked By</th>
			<th>Detail</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($reals as $key => $real) : ?>
			<?php 
				if($real->checked==1) 
					// $image = Yii::app()->baseUrl."/images/icons/tick.png";
					$image = "fa fa-check fa-success";
				else 
					// $image = Yii::app()->baseUrl."/images/icons/cancel.png";
					$image = "fa fa-times fa-error";
			 ?>
			<tr>
				<td><?php echo $real->name; ?></td>
				<!-- <td><img src="<?php echo $image; ?>" alt="<?php echo $real->checked ?>" style="width:16px;height:16px;"></td> -->
				<td><i class="<?php echo $image; ?> fa-2x" aria-hidden="true"></i> <?php //echo $real->checked ?></td>
				<td><?php echo $real->checked_date != "" ? $real->checked_date : ''; ?></td>
				<td><?php echo $real->checked_by != "" ? $real->checked_by : ''; ?></td>
				<td><?php echo $real->detail != "" ? $real->detail : ''; ?></td>
				<td><a class="button cbutton center" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/registrationTransaction/ajaxHtmlUpdate',array('id'=>$real->id));?>"><span class="fa fa-pencil"></span>Update</a>
						
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

