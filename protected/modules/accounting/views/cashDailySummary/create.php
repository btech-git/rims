<div class="form">
    <h2>KAS HARIAN</h2>
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($cashDaily); ?>
    <?php $branch = Branch::model()->findByPk($cashDaily->branch_id); ?>
    <?php $paymentType = PaymentType::model()->findByPk($cashDaily->payment_type_id); ?>
    
    <div class="row">
        <table>
            <thead>
                <tr>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Branch', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Tanggal', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Payment Type', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Amount', ''); ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($cashDaily, 'transaction_date'))); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cashDaily, 'amount'))); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <table>
            <thead>
                <tr>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Invoice #', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Tanggal', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Jatuh Tempo', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Customer', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Vehicle', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Invoice Status', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Grand Total', ''); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid">
                        <?php echo CHtml::label('Remaining', ''); ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentIns as $paymentIn): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'invoice.invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($paymentIn, 'invoice.invoice_date'))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($paymentIn, 'invoice.due_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'vehicle.plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'invoice.status')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentIn, 'invoice.total_price'))); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentIn, 'invoice.payment_left'))); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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