<div class="form">
    <h2>KAS HARIAN</h2>
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($cashDaily); ?>
    
    <div class="row">
        <table>
            <thead>
                <tr>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid"><?php echo CHtml::label('Branch', ''); ?></td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid"><?php echo CHtml::label('Tanggal', ''); ?></td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid"><?php echo CHtml::label('Payment Type', ''); ?></td>
                    <td style="text-align: center; font-weight: bold; border-bottom: 1px solid"><?php echo CHtml::label('Amount', ''); ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php $branch = Branch::model()->findByPk($cashDaily->branch_id); ?>
                        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($cashDaily, 'transaction_date'))); ?></td>
                    <td>
                        <?php $paymentType = PaymentType::model()->findByPk($cashDaily->payment_type_id); ?>
                        <?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cashDaily, 'amount'))); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

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