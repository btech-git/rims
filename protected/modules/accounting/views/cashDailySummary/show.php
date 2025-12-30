<div class="form">
    <h2>KAS HARIAN DETAIL TRANSAKSI</h2>
    
    <div class="row">
        <table>
            <thead>
                <tr>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Tanggal', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Total Daily', ''); ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($cashDaily, 'transaction_date'))); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cashDaily, 'amount'))); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'payment-in-grid',
            'dataProvider' => $dataProvider,
            'filter' => NULL,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'name' => 'payment_number',
                    'value' => 'CHtml::link($data->payment_number, array("/transaction/paymentIn/view", "id"=>$data->id))',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'payment_date', 
                    'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date))',
                ),
                array(
                    'name' => 'customer_name', 
                    'value' => '$data->customer->name'
                ),
                array(
                    'name' => 'payment_type_id', 
                    'value' => '$data->paymentType->name'
                ),
                array(
                    'header' => 'Payment', 
                    'value' => 'AppHelper::formatMoney($data->payment_amount)',
                    'htmlOptions' => array('style' => 'text-align: right'),
                ),
                array(
                    'name' => 'status', 
                    'value' => '$data->status'
                ),
            ),
        )); ?>
    </div>
</div><!-- form -->