<div class="form">
    <h2>KAS HARIAN</h2>
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($cashDaily); ?>
    <?php //$branch = Branch::model()->findByPk($cashDaily->branch_id); ?>
    <?php //$paymentType = PaymentType::model()->findByPk($cashDaily->payment_type_id); ?>
    
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
                    'name' => 'invoice_id', 
                    'value' => 'CHtml::link($data->invoice->invoice_number, array("/transaction/invoiceHeader/view", "id"=>$data->invoice_id))',
                    'type' => 'raw'
                ),
                array(
                    'header' => 'Tanggal Inv', 
                    'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice->invoice_date))',
                ),
                array(
                    'header' => 'Jatuh Tempo', 
                    'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice->due_date))',
                ),
                array(
                    'name' => 'customer_name', 
                    'value' => '$data->customer->name'
                ),
                array(
                    'header' => 'Plate #', 
                    'value' => 'empty($data->invoice_id) ? "N/A" : empty($data->invoice->vehicle_id) ? "N/A" : $data->invoice->vehicle->plate_number'
                ),
                array(
                    'header' => 'Invoice Status',
                    'name' => 'invoice_status',
                    'value' => '$data->invoice->status',
                ),
                array(
                    'header' => 'Payment', 
                    'value' => 'AppHelper::formatMoney($data->payment_amount)',
                    'htmlOptions' => array('style' => 'text-align: right'),
                ),
                array(
                    'header' => 'Remaining', 
                    'value' => 'AppHelper::formatMoney($data->invoice->payment_left)',
                    'htmlOptions' => array('style' => 'text-align: right'),
                ),
            ),
        )); ?>
    </div>
            
    <hr />
    
    <div class="row">
        <?php echo CHtml::label('Memo', ''); ?>
        <?php echo CHtml::activeTextField($cashDaily, 'memo'); ?>
        <?php echo CHtml::error($cashDaily, 'memo'); ?>        
    </div>
    
    <hr />
    
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $cashDaily,
                    'attribute' => 'images',
                    'accept' => 'jpg|jpeg|png|gif',
                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                    'max' => 10,
                    'remove' => '[x]',
                    'duplicate' => 'Already Selected',
                    'options' => array(
                        'afterFileSelect' => 'function(e ,v ,m){
                            var fileSize = e.files[0].size;
                            if (fileSize > 2*1024*1024){
                                alert("Exceeds file upload limit 2MB");
                                $(".MultiFile-remove").click();
                            }                      
                            return true;
                        }',
                    ),
                )); ?>
            </div>
        </div>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Approve', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->