<div id="transaction-form">
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($invoice->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM INVOICE</legend>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($invoice->header, 'invoice_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $invoice->header,
                        'attribute' => "invoice_date",
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
                    <?php echo CHtml::error($invoice->header, 'invoice_date'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::activeLabelEx($invoice->header, 'due_date', array('class' => 'form-label', 'label' => 'Jatuh Tempo')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'model' => $invoice->header,
                        'attribute' => "due_date",
                        'options'=>array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions'=>array(
                            'readonly' => true,
                            'class' => 'form-control readonly-form-input',
                        ),
                    )); ?>
                    <?php echo CHtml::error($invoice->header, 'due_date'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Branch', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'branch_id', array('value' => $invoice->header->branch_id)); ?>
                    <?php echo CHtml::textField('BranchName', $invoice->header->branch->name, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('BR/GR #', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'registration_transaction_id', array('value' => $invoice->header->registration_transaction_id)); ?>
                    <?php echo CHtml::textField('TransactionNumber', $invoice->header->registrationTransaction->transaction_number, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Customer', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'customer_id', array('value' => $invoice->header->customer_id)); ?>
                    <?php echo CHtml::textField('CustomerName', $invoice->header->customer->name, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Plat #', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'vehicle_id', array('value' => $invoice->header->vehicle_id)); ?>
                    <?php echo CHtml::textField('VehiclePlateNumber', $invoice->header->vehicle->plate_number, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Insurance', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'insurance_company_id', array('value' => $invoice->header->insurance_company_id)); ?>
                    <?php $insuranceCompany = empty($invoice->header->insurance_company_id) ? '' : $invoice->header->insuranceCompany->name; ?>
                    <?php echo CHtml::textField('InsuranceName', $insuranceCompany, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Sales Type', false, array('class' => 'form-label')); ?>
                    <?php $saleType = $invoice->header->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?>
                    <?php echo CHtml::textField('VehiclePlateNumber', $saleType, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Catatan', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::ActiveTextArea($invoice->header, 'note', array('rows' => 3, 'cols' => 50, 'class' => 'form-control')); ?>
                    <?php echo CHtml::error($invoice->header, 'note'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Kendaraan', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($invoice->header, 'vehicle_id', array('value' => $invoice->header->vehicle_id)); ?>
                    <?php echo CHtml::textField('VehiclePlateNumber', $invoice->header->vehicle->plate_number, array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">PRODUK - JASA</legend>
            <div class="detail" id="detail">
                <?php $this->renderPartial('_detail', array('invoice' => $invoice)); ?>
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
