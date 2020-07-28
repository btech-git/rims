<?php
/* @var $this JurnalUmumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jurnal Umums',
);

$this->menu=array(
	array('label'=>'Create JurnalUmum', 'url'=>array('create')),
	array('label'=>'Manage JurnalUmum', 'url'=>array('admin')),
);
?>

<h1>Jurnal Umum</h1>
<div class="medium-4 columns">
	<?php $attribute = 'tanggal_transaksi'; ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'id'=>CHtml::activeId($model, $attribute.'_0'),
		'model'=>$model,
		'attribute'=>$attribute."_from",
		'options'=>array('dateFormat'=>'yy-mm-dd'),
		'htmlOptions'=>array(
		    'style'=>'margin-bottom:0px;',
	    	'placeholder'=>'Transaction Date From'
		),
	)); ?>
</div>	

<div class="medium-4 columns">
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'id'=>CHtml::activeId($model, $attribute.'_1'),
        'model'=>$model,
        'attribute'=>$attribute."_to",
        'options'=>array('dateFormat'=>'yy-mm-dd'),
        'htmlOptions'=>array(
            'style'=>'margin-bottom:0px;',
            'placeholder'=>'Transaction Date To'
        ),
    )); ?>									
</div>	

<?php if (Yii::app()->user->checkAccess("accounting.jurnalUmum.exportExcel")) { ?>
    <a class="button success right" href="<?php echo Yii::app()->baseUrl.'/accounting/jurnalUmum/exportExcel';?>"><span class="fa fa-print"></span>Export Excel</a> &nbsp;
<?php }?>
<?php //$this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); ?>

<div class="detail">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'jurnal-umum-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
            'id',
            'kode_transaksi',
            'tanggal_transaksi',
            'coa_id',
            'branch_id',
            'total',
            array(
                'class'=>'CButtonColumn',
            ),
        ),
    )); ?>
	<!-- <table>
		<thead>
			<th>TANGGAL</th>
			<th>KODE TRANSAKSI</th>
			<th>KODE</th>
			<th>NAMA</th>
			<th>DEBET</th>
			<th>KREDIT</th>
		</thead>
		<tbody>
			<?php $lastkode = ""; ?>
			<?php foreach ($jurnals as $key => $jurnal): ?>
				<tr>
					<td>
						<?php echo $lastkode == $jurnal->kode_transaksi ?"": $jurnal->tanggal_posting; ?>
					</td>
					<td>
						<?php echo $lastkode == $jurnal->kode_transaksi ?"": $jurnal->kode_transaksi; ?>
					</td>
					<td><?php echo empty($jurnal->coa) ? "xxx" : $jurnal->branchAccountCode; ?></td>
					<td><?php echo empty($jurnal->coa) ? "" : $jurnal->coa->name ?></td>
					<td><?php echo $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '' ?></td>
					<td><?php echo $jurnal->debet_kredit == 'K'? number_format($jurnal->total,5) : '' ?></td>
				</tr>
				<?php $lastkode = $jurnal->kode_transaksi; ?>
			<?php endforeach ?>
		</tbody>
	</table> -->
</div>
