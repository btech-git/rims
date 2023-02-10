<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($paymentOut->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $paymentOut->header,
                            'attribute' => "payment_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'payment_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Status', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'status')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'user.username')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php if ($paymentOut->header->isNewRecord): ?>
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Branch --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'branch_id'); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($paymentOut->header, 'branch.name'));?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Type', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Payment Type --',
                            'onchange' => '
                                if ($(this).val() == 1) {
                                    $(".giro").hide();
                                    $(".bank").hide();
                                } else {
                                    $(".bank").show();
                                    $(".giro").show();
                                }
                            '
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="giro">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Giro #', ''); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($paymentOut->header, 'nomor_giro'); ?>
                            <?php echo CHtml::error($paymentOut->header, 'nomor_giro'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bank">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Bank', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($paymentOut->header, 'bank_id', CHtml::listData(Bank::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Bank --'
                            )); ?>
                            <?php echo CHtml::error($paymentOut->header, 'bank_id'); ?>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Supplier Company', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'company')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Name', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Address', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'address')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Phone', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($supplier, 'phone')); ?>
                    </div>
                </div>
            </div>	
            
            <div class="field" >
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Company Bank', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
                            $branchId = $paymentOut->header->isNewRecord ? User::model()->findByPk(Yii::app()->user->getId())->branch_id : $paymentOut->header->branch_id;
                            $branch = Branch::model()->findByPk($branchId);
                            $company = Company::model()->findByPk($branch->company_id);
                        ?>
                        <?php echo CHtml::activeDropDownList($paymentOut->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                            'empty' => '-- Select Company Bank --'
                        )); ?>
                        <?php echo CHtml::error($paymentOut->header, 'company_bank_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Catatan', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($paymentOut->header, 'notes', array('rows' => 5, 'cols' => 30)); ?>
                        <?php echo CHtml::error($paymentOut->header, 'notes'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr />

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'paymentOut' => $paymentOut,
            'receiveItem' => $receiveItem,
            'workOrderExpense' => $workOrderExpense,
            'movementType' => $movementType,
        )); ?>
    </div>
	
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $paymentOut->header,
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
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->