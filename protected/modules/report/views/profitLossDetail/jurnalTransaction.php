<?php echo CHtml::beginForm(array(''), 'get'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Transaction Detail</div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($coa, 'codeName')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<div class="clear"></div>

<div class="row buttons">
    <?php echo CHtml::hiddenField('CoaId', $coaId); ?>
    <?php echo CHtml::hiddenField('StartDate', $startDate); ?>
    <?php echo CHtml::hiddenField('EndDate', $endDate); ?>
    <?php echo CHtml::hiddenField('BranchId', $branchId); ?>
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>
<br />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-item-grid',
        'dataProvider'=>$jurnalUmumDataProvider,
        'filter'=>null,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'kode_transaksi', 
                'value'=>'CHtml::link($data->kode_transaksi, array("generalLedger/redirectTransaction", "codeNumber"=>$data->kode_transaksi), array("target" => "_blank"))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'tanggal_transaksi', 
                'value'=>'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->tanggal_transaksi))', 
            ),
            'transaction_subject',
            'transaction_type',
            array(
                'header' => 'Debit',
                'name'=>'total', 
                'value'=>'$data->debet_kredit == "D" ? AppHelper::formatMoney($data->total) : 0', 
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Kredit',
                'name'=>'total', 
                'value'=>'$data->debet_kredit == "K" ? AppHelper::formatMoney($data->total) : 0', 
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>
</div>