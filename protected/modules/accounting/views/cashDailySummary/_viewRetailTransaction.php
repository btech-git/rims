<div>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'asset-purchase-grid',
        'dataProvider'=>$retailTransactionDataProvider,
        'filter'=>null,
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns'=>array(
            array(
                'name' => 'transaction_number', 
                'value' => 'CHtml::link($data->transaction_number, array("/frontDesk/generalRepairRegistration/view", "id"=>$data->id), array("target" => "_blank"))',
                'type' => 'raw',
            ),
            'transaction_date',
            array(
                'header' => 'Customer', 
                'value' => '$data->customer->name',
            ),
            array(
                'name' => 'grand_total',
                'value' => 'number_format($data->grand_total, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right'         
                ),
            ),
            'status',
        ),
    )); ?>
    
    <div style="text-align: right">Total Sales Retail: <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $this->reportGrandTotalRetailTransaction($retailTransactionDataProvider))); ?></div>

</div>