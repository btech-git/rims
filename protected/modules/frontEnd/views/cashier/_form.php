<div>
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($paymentIn->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM PAYMENT</legend>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'payment_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $paymentIn->header,
                        'attribute' => "payment_date",
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => 'form-control readonly-form-input',
                        ),
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header,'payment_date'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Payment Type', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeDropDownlist($paymentIn->header, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                        'prompt' => '[--Select Payment Type--]',
                        'class' => 'form-control',
                        'onchange' => '
                            if ($(this).val() == 6) {
                                $("#' . CHtml::activeId($paymentIn->header, 'nomor_giro') . '").prop("readonly", false);
                                $("#' . CHtml::activeId($paymentIn->header, 'bank_id') . '").prop("readonly", true);
                            } else {
                                $("#' . CHtml::activeId($paymentIn->header, 'nomor_giro') . '").prop("readonly", true);
                                $("#' . CHtml::activeId($paymentIn->header, 'bank_id') . '").prop("readonly", false);
                            }
                        '
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header, 'payment_type_id'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php $branch = Branch::model()->findByPk($paymentIn->header->branch_id); ?>
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'branch_id', array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('BranchName', $branch->name, array(
                        'class' => 'form-control',
                        'readonly' => true
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header, 'branch_id'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'company_bank_id', array('class' => 'form-label')); ?>
                    <?php $company = Company::model()->findByPk($paymentIn->header->branch->company_id); ?>
                    <?php echo CHtml::activeDropDownlist($paymentIn->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                        'prompt' => '[--Select Company Bank--]',
                        'class' => 'form-control',
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header,'company_bank_id'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'status', array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeTextField($paymentIn->header, 'status', array(
                        'size' => 30, 
                        'maxlength' => 30, 
                        'class' => 'form-control',
                        'readonly' => true
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header, 'status'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'nomor_giro', array('class' => 'form-label', 'label' => 'Giro #')); ?>
                    <?php echo CHtml::activeTextField($paymentIn->header, 'nomor_giro', array('maxlength' => 20, 'size' => 20, 'class' => 'form-control',)); ?>
                    <?php echo CHtml::error($paymentIn->header, 'nomor_giro'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php $user = Users::model()->findByPk($paymentIn->header->user_id); ?>
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'user_id', array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($paymentIn->header, 'user_id'); ?>
                    <?php echo CHtml::textField('UserName', $user->username, array(
                        'class' => 'form-control',
                        'readonly' => true
                    )); ?>
                    <?php echo CHtml::error($paymentIn->header,'user_id'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::activeLabelEx($paymentIn->header, 'notes', array('class' => 'form-label', 'label' => 'Catatan')); ?>
                    <?php echo CHtml::activeTextArea($paymentIn->header,'notes',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                    <?php echo CHtml::error($paymentIn->header, 'notes'); ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Detail Payment</legend>
            <div class="detail" id="detail-product">
                <?php $this->renderPartial('_detail', array(
                    'paymentIn' => $paymentIn,
                )); ?>
            </div>
        </fieldset>

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    
    <?php echo CHtml::endForm(); ?>
</div>

<script>
    $(document).ready(function() {
        $('#back-button').on('click', function() {
            $('#transaction-form').addClass('d-none');
            $('#master-list').removeClass('d-none');
        });
    });
</script>
