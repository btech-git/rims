<?php
/* @var $this JurnalUmumController */
/* @var $data JurnalUmum */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kode_transaksi')); ?>:</b>
	<?php echo CHtml::encode($data->kode_transaksi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_transaksi')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_transaksi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coa_id')); ?>:</b>
	<?php echo CHtml::encode($data->coa_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debet_kredit')); ?>:</b>
	<?php echo CHtml::encode($data->debet_kredit); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tanggal_posting')); ?>:</b>
	<?php echo CHtml::encode($data->tanggal_posting); ?>
	<br />

	*/ ?>

</div>